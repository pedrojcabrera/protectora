# Script SYNC - Ejecutar antes de abandonar VS Code
# Sincroniza los cambios locales con GitHub

Write-Host "=== SCRIPT SYNC - Subiendo cambios a GitHub ===" -ForegroundColor Cyan
Write-Host ""

# Verificar el estado del repositorio
Write-Host "Verificando estado del repositorio..." -ForegroundColor Yellow
git status

Write-Host ""
Write-Host "Agregando todos los archivos modificados..." -ForegroundColor Green
git add .

# Solicitar mensaje de commit
Write-Host ""
$mensaje = Read-Host "Introduce el mensaje del commit (o presiona Enter para usar mensaje automático)"
if ([string]::IsNullOrWhiteSpace($mensaje)) {
    $mensaje = "Actualización automática - $(Get-Date -Format 'dd/MM/yyyy HH:mm')"
    Write-Host "Usando mensaje automático: $mensaje" -ForegroundColor Gray
}

Write-Host ""
Write-Host "Realizando commit..." -ForegroundColor Green
git commit -m $mensaje

Write-Host ""
Write-Host "Subiendo cambios a GitHub..." -ForegroundColor Green
git push origin main

# Si falla el push normal, preguntar si hacer push forzado
if ($LASTEXITCODE -ne 0) {
    Write-Host ""
    Write-Host "El push normal falló. Esto puede ocurrir si el repositorio remoto tiene cambios diferentes." -ForegroundColor Yellow
    Write-Host "Opciones:"
    Write-Host "  S - Hacer push forzado (recomendado si tu desarrollo está más avanzado)"
    Write-Host "  N - Cancelar y revisar manualmente"
    Write-Host ""
    
    do {
        $respuesta = Read-Host "¿Hacer push forzado? (S/N)"
        $respuesta = $respuesta.Trim().ToUpper()
    } while ($respuesta -ne "S" -and $respuesta -ne "N")
    
    if ($respuesta -eq "S") {
        Write-Host ""
        Write-Host "Realizando push forzado..." -ForegroundColor Red
        git push origin main --force
    } else {
        Write-Host ""
        Write-Host "Push cancelado. Revisa los cambios manualmente." -ForegroundColor Yellow
    }
}

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "¡Sincronización completada exitosamente!" -ForegroundColor Yellow
    Write-Host "Ya puedes cerrar VS Code con seguridad." -ForegroundColor Yellow
} else {
    Write-Host ""
    Write-Host "Error durante la sincronización. Revisa los mensajes anteriores." -ForegroundColor Red
}

Write-Host ""
Read-Host "Presiona Enter para salir"