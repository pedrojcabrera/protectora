<?php

namespace App\Controllers;

use App\Models\SociosModel;
use App\Models\SociosCHModel;
use App\Models\RecibosModel;
use App\Models\RemesasModel;
use DateTime;
use DateInterval;
use CodeIgniter\I18n\Time;


class RemesasController extends BaseController
{
    protected $sociosModel;
    protected $historicoModel;
    protected $recibosModel;
    protected $remesasModel;

    public function __construct()
    {
        $this->sociosModel  = new SociosModel();
        $this->historicoModel = new SociosCHModel();
        $this->recibosModel = new RecibosModel();
        $this->remesasModel = new RemesasModel();
    }
    
    public function BuscarNuevosRecibos()
    {
        // if(session()->usuario_usuario === null || !session()->usuario_usuario){ 
        //     return view('login');
        // }
        $cuotaAnual   = session()->get('prote_cuota_anual');
        $diaRemesa    = session()->get('prote_dia_remesa'); 
        $hoy          = new DateTime();
        // $hoy = Time::now()->addMonths(4);


        // Calcular fecha de remesa (día más próximo >= hoy)
        $fechaRemesa = new DateTime($hoy->format('Y-m-') . str_pad($diaRemesa, 2, '0', STR_PAD_LEFT));
        if ($fechaRemesa < $hoy) {
            $fechaRemesa->modify('+1 month');
            $fechaRemesa->setDate(
                $fechaRemesa->format('Y'),
                $fechaRemesa->format('m'),
                $diaRemesa
            );
        }

        $num_remesa_bancaria = 'RBAN-' . $fechaRemesa->format('Ymd');
        $num_remesa_ingresos = 'ICTA-' . $fechaRemesa->format('Ymd');

        if ($remesa = $this->remesasModel->where('remesa', $num_remesa_bancaria)->first()) {

            $id_remesa_bancaria = $remesa->id;
        
        } else {

            $this->remesasModel->insert([
                'remesa'      => $num_remesa_bancaria,
                'tipo'        => 'recibo',
                'fecha'       => $fechaRemesa->format('Y-m-d'),
                'importe'     => 0, // se actualizará luego
                'estado'      => 'pendiente',
            ]);

            $id_remesa_bancaria =  $this->remesasModel->getInsertID();
        }
        
        if ($remesa = $this->remesasModel->where('remesa', $num_remesa_ingresos)->first()) {

            $id_remesa_ingresos = $remesa->id;
        
        } else {

            $this->remesasModel->insert([
                'remesa'      => $num_remesa_ingresos,
                'tipo'        => 'ingreso',
                'fecha'       => $fechaRemesa->format('Y-m-d'),
                'importe'     => 0, // se actualizará luego
                'estado'      => 'pendiente'
            ]);

            $id_remesa_ingresos =  $this->remesasModel->getInsertID();
        }

        $socios = $this->sociosModel
                    ->where('tipo', 'socio')
                    ->where('tipo !=', 'ninguno')
                    ->findAll();
        $recibosGenerados = [];

        foreach ($socios as $socio) {
            $importe = 0;
            $meses   = 0;

            // Calcular importe y periodicidad
            switch ($socio->modalidad_pago) {
                case 'anual':
                    $importe = $cuotaAnual + $socio->complemento;
                    $meses = 12;
                    break;
                case 'semestral':
                    $importe = ($cuotaAnual  + $socio->complemento) / 2;
                    $meses = 6;
                    break;
                case 'cuatrimestral':
                    $importe = ($cuotaAnual + $socio->complemento) / 3;
                    $meses = 4;
                    break;
                case 'trimestral':
                    $importe = ($cuotaAnual + $socio->complemento) / 4;
                    $meses = 3;
                    break;
                case 'mensual':
                    $importe = ($cuotaAnual + $socio->complemento) / 12;
                    $meses = 1;
                    break;
                default:
                    continue 2; // saltar socio sin modalidad
            }

            $fechaRecibo = null;
            $ultimoRecibo = $this->historicoModel->ultimoPorSocio($socio->id);
            if (!$ultimoRecibo) {
                // Primer recibo → en la remesa actual
                $fechaRecibo = $fechaRemesa;
            } else {
                // Calcular siguiente fecha
                $ultima = new DateTime($ultimoRecibo->fecha);
                $siguiente = (clone $ultima)->add(new DateInterval("P{$meses}M"));
                if ($siguiente <= $fechaRemesa) {
                    $fechaRecibo = $fechaRemesa;
                }
            }
            if ($fechaRecibo) {
                if($socio->forma_de_pago === 'ingreso') {
                    $id_remesa = $id_remesa_ingresos;
                    $num_remesa = $num_remesa_ingresos;
                }
                if($socio->forma_de_pago === 'recibo') {
                    $id_remesa = $id_remesa_bancaria;
                    $num_remesa = $num_remesa_bancaria;
                }
                $dataRecibo = [
                    'socio_id'    => $socio->id,
                    'fecha_cobro' => $fechaRecibo->format('Y-m-d'),
                    'importe'     => $importe,
                    'estado'      => 'pendiente',
                    'remesa'      => $num_remesa,
                    'tipo'        => $socio->forma_de_pago    
                ];
                
                if(!$reciboExistente = $this->recibosModel
                    ->where('socio_id', $socio->id)
                    ->where('remesa', $num_remesa)
                    ->first()) 
                {
                    // solo insertamos si no existe ya un recibo igual
                    $this->recibosModel->insert($dataRecibo);

                    $recibosGenerados[] = (object) array_merge((array) $socio, $dataRecibo);
                }
            }
        }

        // actualizamos la remesa si existen recibos o en caso contrario la quitamos
        $suma = $this->recibosModel
            ->selectSum('importe')
            ->where('remesa', $num_remesa_bancaria)
            ->get()
            ->getRow()
            ->importe ?? 0;

        if ($suma > 0) {
            $this->remesasModel->update($id_remesa_bancaria, ['importe' => $suma]);
        } else {
            $this->remesasModel->delete($id_remesa_bancaria);
        }

        $suma = $this->recibosModel
            ->selectSum('importe')
            ->where('remesa', $num_remesa_ingresos)
            ->get()
            ->getRow()
            ->importe ?? 0;

        if ($suma > 0) {
            $this->remesasModel->update($id_remesa_ingresos, ['importe' => $suma]);
        } else {
            $this->remesasModel->delete($id_remesa_ingresos);
        }
        
        // Mostrar vista con los recibos generados
		$recibos_bancarios = $this->recibosModel->getRecibosBancariosConSocio();
        $recibos_ingresos = $this->recibosModel->getRecibosIngresosConSocio();

        $remesa_bancaria = $this->remesasModel->find($id_remesa_bancaria);
        $remesa_ingresos = $this->remesasModel->find($id_remesa_ingresos);

        return view('remesas/buscaNuevos', [
			'recibos_bancarios' => $recibos_bancarios,
			'recibos_ingresos'  => $recibos_ingresos,
            'remesa_bancaria' => $remesa_bancaria,
            'remesa_ingresos' => $remesa_ingresos,
			'fechaRemesa' => $fechaRemesa->format('d-m-Y') // o la fecha que quieras mostrar
		]);
	}	

    public function exportar()
    {
        $recibosModel = new RecibosModel();
        $sociosModel  = new SociosModel();

        // 1. Obtener recibos pendientes
        $recibos = $recibosModel
                    ->where('estado', 'pendiente')
                    ->where('tipo', 'recibo')
                    ->findAll();

        if (empty($recibos)) {
            return redirect()->back()->with('mensaje', 'No hay recibos pendientes para exportar');
        }

        // 2. Crear XML base SEPA
        $doc = new \DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = true;

        $root = $doc->createElement('Document');
        $root->setAttribute('xmlns', 'urn:iso:std:iso:20022:tech:xsd:pain.008.001.02');
        $root->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $doc->appendChild($root);

        // Grupo principal
        $cstmrDrctDbtInitn = $doc->createElement('CstmrDrctDbtInitn');
        $root->appendChild($cstmrDrctDbtInitn);

        // Cabecera del mensaje
        $grpHdr = $doc->createElement('GrpHdr');
        $grpHdr->appendChild($doc->createElement('MsgId', 'REMESA-' . date('YmdHis')));
        $grpHdr->appendChild($doc->createElement('CreDtTm', date('Y-m-d\TH:i:s')));
        $grpHdr->appendChild($doc->createElement('NbOfTxs', count($recibos)));
        $grpHdr->appendChild($doc->createElement('CtrlSum', array_sum(array_column($recibos, 'importe'))));
        $cstmrDrctDbtInitn->appendChild($grpHdr);

        // Info de la remesa (deudor = socios, acreedor = protectora)
        $pmtInf = $doc->createElement('PmtInf');
        $pmtInf->appendChild($doc->createElement('PmtInfId', 'REMESA-' . date('Ymd')));
        $pmtInf->appendChild($doc->createElement('PmtMtd', 'DD')); // Débito directo
        $pmtInf->appendChild($doc->createElement('NbOfTxs', count($recibos)));
        $pmtInf->appendChild($doc->createElement('CtrlSum', array_sum(array_column($recibos, 'importe'))));

        // Datos de la cuenta acreedora (TU protectora, cámbialo a tus datos reales)
        $cdtr = $doc->createElement('Cdtr');
        $cdtr->appendChild($doc->createElement('Nm', session('prote_nombre')));
        $pmtInf->appendChild($cdtr);

        $cdtrAcct = $doc->createElement('CdtrAcct');
        $cdtrAcct->appendChild($doc->createElement('IBAN', 'ES7620770024003102575766'));
        $pmtInf->appendChild($cdtrAcct);

        $cstmrDrctDbtInitn->appendChild($pmtInf);

        // 3. Añadir cada recibo
        foreach ($recibos as $recibo) {
            $socio = $sociosModel->find($recibo->socio_id);

            $drctDbtTxInf = $doc->createElement('DrctDbtTxInf');

            $pmtId = $doc->createElement('PmtId');
            $pmtId->appendChild($doc->createElement('EndToEndId', 'RECIBO-' . $recibo->id . ' - ' . session('prote_nombre_corto')));
            $drctDbtTxInf->appendChild($pmtId);

            $instdAmt = $doc->createElement('InstdAmt', number_format($recibo->importe, 2, '.', ''));
            $instdAmt->setAttribute('Ccy', 'EUR');
            $drctDbtTxInf->appendChild($instdAmt);

            $dbtr = $doc->createElement('Dbtr');
            $dbtr->appendChild($doc->createElement('Nm', $socio->nombre));
            $drctDbtTxInf->appendChild($dbtr);

            $dbtrAcct = $doc->createElement('DbtrAcct');
            $dbtrAcct->appendChild($doc->createElement('IBAN', $socio->iban));
            $drctDbtTxInf->appendChild($dbtrAcct);

            $pmtInf->appendChild($drctDbtTxInf);

            $this->historicoModel->insert([
                'socio_id' => $recibo->socio_id,
                'fecha'    => $recibo->fecha_cobro,
                'importe'  => $recibo->importe,
            ]);
        }

        // 4. Actualizar el estado en tablas remesas y recibos
        $cuotaAnual   = session()->get('prote_cuota_anual');
        $diaRemesa    = session()->get('prote_dia_remesa'); 
        $hoy          = new DateTime();

        $fechaRemesa = new DateTime($hoy->format('Y-m-') . str_pad($diaRemesa, 2, '0', STR_PAD_LEFT));
        if ($fechaRemesa < $hoy) {
            $fechaRemesa->modify('+1 month');
            $fechaRemesa->setDate(
                $fechaRemesa->format('Y'),
                $fechaRemesa->format('m'),
                $diaRemesa
            );
        }

        $num_remesa = 'RBAN-' . $fechaRemesa->format('Ymd');

        $remesa = $this->remesasModel->where('remesa', $num_remesa)->first();

        $this->remesasModel->where('remesa', $num_remesa)->set('estado', 'enviado')->update();
        $this->recibosModel->where('remesa', $num_remesa)->set('estado', 'enviado')->update();

        // 5. Descargar el archivo
        $xmlOutput = $doc->saveXML();

        $this->response
            ->setHeader('Content-Type', 'application/xml')
            ->setHeader('Content-Disposition', 'attachment; filename="remesa_' . date('Ymd_His') . '.xml"')
            ->setBody($xmlOutput);
            
        return redirect()->to('remesas/buscaNuevos');
    }
    
    public function listadoRemesas()
    {
        $db = \Config\Database::connect();

        // Obtener resumen de remesas
        $sql = "
            SELECT r.remesa,
                   r.fecha_cobro,
                   COUNT(r.id) AS num_recibos,
                   SUM(r.importe) AS total
            FROM recibos r
            GROUP BY r.fecha_cobro,r.remesa
            ORDER BY r.fecha_cobro, r.remesa DESC
        ";

        $remesas = $db->query($sql)->getResult();

        // Añadir detalles a cada remesa
        foreach ($remesas as &$remesa) {
            $remesa->detalles = $this->recibosModel
                ->select('recibos.remesa, recibos.fecha_cobro, recibos.importe, recibos.estado, socios.nombre')
                ->join('socios', 'socios.id = recibos.socio_id', 'left')
                ->where('recibos.remesa', $remesa->remesa)
                ->findAll();
        }

        return view('remesas/listadoRemesas', ['remesas' => $remesas]);
    }

    public function cartaAvisoRecibo()
    {
        $recibosModel = new RecibosModel();
        $sociosModel  = new SociosModel();
        
        // 1. Obtener recibos pendientes (igual que en exportar)
        $recibos = $recibosModel
        ->where('estado', 'pendiente')
        ->where('tipo', 'recibo')
        ->findAll();
        
        if (empty($recibos)) {
            return redirect()->back()->with('mensaje', 'No hay recibos pendientes para enviar avisos');
        }
        
        // 2. Configurar email
        
        $emailConfig = $this->emailConfig();
        
        // 3. Contadores para el resumen
        $enviados = 0;
        $errores = 0;
        $erroresList = [];
        $mensajes = []; // ← AÑADIDO: Inicializar la variable
        
        // 4. Enviar email a cada socio
        foreach ($recibos as $recibo) {
            $socio = $sociosModel->find($recibo->socio_id);
            if ($socio && !empty($socio->email)) {
                // Formatear datos
                $fechaCobro = new DateTime($recibo->fecha_cobro);
                $importeFormateado = number_format($recibo->importe, 2, ',', '.');
                
                // Configurar email
                $email = \Config\Services::email($emailConfig);
                //$email->initialize($emailConfig);
                $email->setFrom(session('prote_mail_usuario'), session('prote_nombre'));
                $email->setTo($socio->email);
                $email->setSubject('Aviso de cobro de cuota - ' . session('prote_nombre'));
                
                //dd($email);


                // Generar contenido HTML del email
                $mensaje = $this->generarMensajeEmail([
                    'nombre' => $socio->nombre,
                    'importe' => $importeFormateado,
                    'fecha_cobro' => $fechaCobro->format('d/m/Y'),
                    'remesa' => $recibo->remesa,
                    'protectora_nombre' => session('prote_nombre'),
                    'protectora_telefono' => session('prote_telefono') ?? '',
                    'protectora_email' => session('prote_email') ?? ''
                ]);
                
                $email->setMessage($mensaje);
                
                // Enviar email

                if ($email->send()) {
                    $enviados++;
                    $mensajes[] = [
                        'socio' => $socio->nombre,
                        'email' => $socio->email,
                    ];
                } else {
                    $errores++;
                    $erroresList[] = [
                        'socio' => $socio->nombre,
                        'email' => $socio->email,
                        'error' => $email->printDebugger(['headers'])
                    ];
                }
                
                $email->clear(); // Limpiar para el siguiente envío
            } else {
                $errores++;
                $erroresList[] = [
                    'socio' => $socio ? $socio->nombre : 'Socio no encontrado',
                    'email' => $socio ? ($socio->email ?? 'Sin email') : 'N/A',
                    'error' => 'Socio sin email válido'
                ];
            }
        }
        
        // 5. Mostrar resumen

        if ($errores > 0) {
            session()->setFlashdata('errores_email', $erroresList);
        }
        if (isset($mensajes) && count($mensajes) > 0) {
            session()->setFlashdata('mensajes', $mensajes);
        }

        $mensaje = "Avisos de recibo enviados: {$enviados} exitosos, {$errores} errores";
        
        return redirect()->back()->with('mensaje', $mensaje);
    }

    private function generarMensajeEmail($datos)
    {
        return "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Aviso de Cobro de Cuota</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #f8f9fa; padding: 20px; border-radius: 5px; text-align: center; margin-bottom: 20px; }
                .content { background-color: #ffffff; padding: 20px; border: 1px solid #dee2e6; border-radius: 5px; }
                .destacado { background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0; }
                .importe { font-size: 18px; font-weight: bold; color: #dc3545; }
                .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6; font-size: 14px; color: #6c757d; }
                table { width: 100%; border-collapse: collapse; margin: 15px 0; }
                td { padding: 8px; border-bottom: 1px solid #dee2e6; }
                .label { font-weight: bold; width: 30%; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h2>{$datos['protectora_nombre']}</h2>
                <p>Aviso de Cobro de Cuota</p>
            </div>
            
            <div class='content'>
                <p><strong>Estimado/a {$datos['nombre']}:</strong></p>
                
                <p>Por medio del presente email, le comunicamos que próximamente procederemos al 
                cobro de su cuota de socio correspondiente.</p>
                
                <div class='destacado'>
                    <h3>📋 Detalles del recibo:</h3>
                    <table>
                        <tr>
                            <td class='label'>💰 Importe:</td>
                            <td><span class='importe'>{$datos['importe']} €</span></td>
                        </tr>
                        <tr>
                            <td class='label'>📅 Fecha de cobro:</td>
                            <td><strong>{$datos['fecha_cobro']}</strong></td>
                        </tr>
                        <tr>
                            <td class='label'>📄 Número de remesa:</td>
                            <td>{$datos['remesa']}</td>
                        </tr>
                    </table>
                </div>
                
                <p>✅ <strong>Le rogamos se asegure de que su cuenta dispone de saldo suficiente 
                para la fecha indicada</strong>, evitando así posibles gastos por devolución.</p>
                
                <p>🐾 Su colaboración es fundamental para que podamos continuar con nuestra 
                labor de protección animal. <strong>Gracias por su compromiso y apoyo continuo.</strong></p>
                
                <p>Si tiene alguna duda o consulta, no dude en contactarnos.</p>
            </div>
            
            <div class='footer'>
                <p><strong>Atentamente,</strong><br>
                <strong>{$datos['protectora_nombre']}</strong></p>
                
                <hr style='margin: 15px 0;'>
                
                <p style='font-size: 12px;'>
                    📧 <strong>Email:</strong> {$datos['protectora_email']}<br>
                    " . (!empty($datos['protectora_telefono']) ? "📞 <strong>Teléfono:</strong> {$datos['protectora_telefono']}<br>" : "") . "
                    
                    <br><em>Este es un email automático, por favor no responda directamente a este mensaje.</em>
                </p>
            </div>
        </body>
        </html>";
    }

    public function cartaAvisoIngreso()
    {
        $recibosModel = new RecibosModel();
        $sociosModel  = new SociosModel();
        $email = \Config\Services::email();
        
        // 1. Obtener recibos pendientes (igual que en exportar)
        $recibos = $recibosModel
        ->where('estado', 'pendiente')
        ->where('tipo', 'ingreso')
        ->findAll();
        
        if (empty($recibos)) {
            return redirect()->back()->with('mensaje', 'No hay recibos pendientes para enviar avisos');
        }

        // 2. Configurar email - CORREGIDO
        $emailConfig = $this->emailConfig();
        $email->initialize($emailConfig);

        // 3. Contadores para el resumen
        $enviados = 0;
        $errores = 0;
        $erroresList = [];
        $mensajes = []; // ← AÑADIDO: Inicializar la variable

        // 4. Enviar email a cada socio
        foreach ($recibos as $recibo) {
            $socio = $sociosModel->find($recibo->socio_id);
            if ($socio && !empty($socio->email)) {
                // Formatear datos
                $fechaCobro = new DateTime($recibo->fecha_cobro);
                $importeFormateado = number_format($recibo->importe, 2, ',', '.');
                
                // Configurar email
                $email->setFrom(session('prote_email'), session('prote_nombre'));
                $email->setTo($socio->email);
                $email->setSubject('Aviso de cobro de cuota - ' . session('prote_nombre'));
                
                // Generar contenido HTML del email
                $mensaje = $this->generarMensajeEmail([
                    'nombre' => $socio->nombre,
                    'importe' => $importeFormateado,
                    'fecha_cobro' => $fechaCobro->format('d/m/Y'),
                    'remesa' => $recibo->remesa,
                    'protectora_nombre' => session('prote_nombre'),
                    'protectora_telefono' => session('prote_telefono') ?? '',
                    'protectora_email' => session('prote_email') ?? ''
                ]);
                
                $email->setMessage($mensaje);
                
                $mensajes[] = [
                    'socio' => $socio->nombre,
                    'email' => $socio->email,
                    'mensaje' => $mensaje
                ];

                // Enviar email
                if ($email->send()) {
                    $enviados++;
                } else {
                    $errores++;
                    $erroresList[] = [
                        'socio' => $socio->nombre,
                        'email' => $socio->email,
                        'error' => $email->printDebugger(['headers'])
                    ];
                }
                
                $email->clear(); // Limpiar para el siguiente envío
            } else {
                $errores++;
                $erroresList[] = [
                    'socio' => $socio ? $socio->nombre : 'Socio no encontrado',
                    'email' => $socio ? ($socio->email ?? 'Sin email') : 'N/A',
                    'error' => 'Socio sin email válido'
                ];
            }
        }
        
        // 5. Mostrar resumen
        dd($mensajes);

        if ($errores > 0) {
            session()->setFlashdata('errores_email', $erroresList);
        }
        if (isset($mensajes) && count($mensajes) > 0) {
            session()->setFlashdata('mensajes', $mensajes);
        }

        $mensaje = "Avisos de recibo enviados: {$enviados} exitosos, {$errores} errores";
        
        return redirect()->back()->with('mensaje', $mensaje);
    }

    private function emailConfig()
    {
            $emailConfig = [
            'protocol'  => session('prote_mail_protocolo'),
            'SMTPHost'  => session('prote_mail_servidor'),
            'SMTPUser'  => session('prote_mail_usuario'),
            'SMTPPass'  => session('prote_mail_password'),
            'SMTPPort'  => (int) session('prote_mail_puerto'),
            'SMTPCrypto'=> session('prote_mail_encriptacion'),
            'mailType'  => session('prote_mail_tipo'),
            'charset'   => session('prote_mail_charset'),
        ];
        return $emailConfig;
    }


}