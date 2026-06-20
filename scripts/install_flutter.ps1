Set-StrictMode -Version Latest
Write-Host 'Installing Git (winget)...'
try { winget install --id Git.Git -e --source winget --accept-package-agreements --accept-source-agreements } catch { Write-Host 'winget Git install may have failed or require approval: ' $_ }

$dest='C:\src'
New-Item -Path $dest -ItemType Directory -Force | Out-Null

Write-Host 'Fetching Flutter releases JSON...'
try {
  $r = Invoke-RestMethod 'https://storage.googleapis.com/flutter_infra_release/releases/releases_windows.json'
  $stable = $r.releases | Where-Object { $_.channel -eq 'stable' } | Sort-Object {[version]$_.version} -Descending | Select-Object -First 1
  $archive = $stable.archive
  $url = "https://storage.googleapis.com/flutter_infra_release/releases/$archive"
  Write-Host "Downloading $url ..."
  $zipPath = Join-Path $dest 'flutter.zip'
  Invoke-WebRequest -Uri $url -OutFile $zipPath -UseBasicParsing
  Expand-Archive -Path $zipPath -DestinationPath $dest -Force
} catch {
  Write-Host 'Failed to download or extract Flutter SDK:' $_
}

$flutterBin = 'C:\src\flutter\bin'
$current = [Environment]::GetEnvironmentVariable('Path','User')
if (-not $current) { $new = $flutterBin } elseif ($current -notlike "*$flutterBin*") { $new = $current + ';' + $flutterBin } else { $new = $current }
try { [Environment]::SetEnvironmentVariable('Path', $new, 'User'); Write-Host "Set user PATH to include $flutterBin" } catch { Write-Host 'Failed to set PATH:' $_ }

$flutterExe = Join-Path $flutterBin 'flutter.bat'
if (Test-Path $flutterExe) { Write-Host 'Running flutter doctor...'; & $flutterExe doctor } else { Write-Host 'flutter.bat not found; installation may have failed.' }
