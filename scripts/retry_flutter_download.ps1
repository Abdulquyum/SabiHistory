Set-StrictMode -Version Latest
$zip='C:\src\flutter.zip'
if (Test-Path $zip) { Write-Host 'Removing partial flutter.zip'; Remove-Item $zip -Force }
[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12
$url='https://storage.googleapis.com/flutter_infra_release/releases/stable/windows/flutter_windows_3.44.0-stable.zip'
Write-Host 'Starting BITS transfer...'
try {
  Start-BitsTransfer -Source $url -Destination $zip -DisplayName 'FlutterDownload' -Description 'Flutter SDK' -Priority High
  Write-Host 'BITS transfer completed.'
} catch {
  Write-Host 'BITS transfer failed:' $_
}

if (Test-Path $zip) { Get-Item $zip | Select-Object Name,Length,LastWriteTime | Format-Table -AutoSize }

if (Test-Path $zip) {
  Write-Host 'Attempting extraction...'
  try { Expand-Archive -Path $zip -DestinationPath 'C:\src' -Force; Write-Host 'Extraction done.' } catch { Write-Host 'Extraction failed:' $_ }
}

if (Test-Path 'C:\src\flutter\bin\flutter.bat') { Write-Host 'Running flutter doctor...'; & 'C:\src\flutter\bin\flutter.bat' doctor } else { Write-Host 'flutter.bat still missing' }
