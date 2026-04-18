param(
    [string] $Message = "Update project"
)

$gitStatus = git status --short

if (-not $gitStatus) {
    Write-Host "Tidak ada perubahan untuk dipush."
    exit 0
}

git add -A

$stagedStatus = git diff --cached --name-only

if (-not $stagedStatus) {
    Write-Host "Tidak ada perubahan yang berhasil distage."
    exit 0
}

git commit -m $Message

if ($LASTEXITCODE -ne 0) {
    exit $LASTEXITCODE
}

git push

exit $LASTEXITCODE
