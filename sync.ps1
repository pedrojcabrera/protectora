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