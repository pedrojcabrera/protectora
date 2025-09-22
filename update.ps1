# Script UPDATE - Ejecutar tras iniciar VS Code
# Actualiza el proyecto local con los cambios de GitHub

Write-Host "=== SCRIPT UPDATE - Descargando cambios desde GitHub ===" -ForegroundColor Cyan
Write-Host ""

# Verificar el estado actual
Write-Host "Verificando estado del repositorio..." -ForegroundColor Yellow
git status

Write-Host ""
Write-Host "Descargando cambios desde GitHub..." -ForegroundColor Green
git pull origin main

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "¡Actualización completada exitosamente!" -ForegroundColor Yellow
    Write-Host "Tu proyecto local está actualizado con la última versión." -ForegroundColor Yellow
    
    # Mostrar últimos commits
    Write-Host ""
    Write-Host "Últimos cambios:" -ForegroundColor Gray
    git log --oneline -5
} else {
    Write-Host ""
    Write-Host "Error durante la actualización. Revisa los mensajes anteriores." -ForegroundColor Red
}

Write-Host ""
Read-Host "Presiona Enter para salir"