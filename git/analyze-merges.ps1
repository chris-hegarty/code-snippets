param(
    [int]$Count = 10,
    [string]$Path = "kiewitv2dev.wpengine.com/wp-content/themes/kiewit/",
    [string]$Since = "1 month ago"
)

Write-Host "`n╔═══════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║   MERGE CONFLICT ANALYSIS - Last $Count Merges              ║" -ForegroundColor Cyan
Write-Host "╚═══════════════════════════════════════════════════════════╝`n" -ForegroundColor Cyan

$merges = git log --merges --format="%H|%s|%P" --since=$Since -- $Path | Select-Object -First $Count

$i = 1
foreach ($merge in $merges) {
    $parts = $merge -split '\|'
    $hash = $parts[0]
    $subject = $parts[1]
    $parents = $parts[2] -split ' '

    Write-Host "[$i/$Count] " -NoNewline -ForegroundColor Yellow
    Write-Host "Merge: " -NoNewline -ForegroundColor White
    Write-Host $hash.Substring(0,9) -ForegroundColor Cyan
    Write-Host "      $subject" -ForegroundColor Gray
    Write-Host "      Parents: " -NoNewline -ForegroundColor White
    Write-Host $parents[0].Substring(0,9) -NoNewline -ForegroundColor Green
    Write-Host " + " -NoNewline
    Write-Host $parents[1].Substring(0,9) -ForegroundColor Green

    # Check for conflicts
    $filesChanged = git diff --name-only $parents[0] $parents[1] -- $Path 2>$null
    $conflictCount = ($filesChanged | Measure-Object).Count

    if ($conflictCount -gt 0) {
        Write-Host "      Files with differences between parents: $conflictCount" -ForegroundColor Yellow
        $shownFiles = 0
        foreach ($file in $filesChanged) {
            if ($shownFiles -ge 5) { break }
            $shortPath = $file -replace '.*themes/kiewit/', 'kiewit/'

            # Check if merge resolution differs from both parents
            $diffParent1 = git diff $parents[0] $hash -- $file 2>$null
            $diffParent2 = git diff $parents[1] $hash -- $file 2>$null

            if ($diffParent1 -and $diffParent2) {
                Write-Host "        " -NoNewline
                Write-Host "CONFLICT " -NoNewline -ForegroundColor Red
                Write-Host $shortPath -ForegroundColor Red
            } else {
                Write-Host "        " -NoNewline
                Write-Host "OK       " -NoNewline -ForegroundColor Green
                Write-Host $shortPath -ForegroundColor Gray
            }
            $shownFiles++
        }
        if ($conflictCount -gt 5) {
            Write-Host "        ... and $($conflictCount - 5) more files" -ForegroundColor Gray
        }
    } else {
        Write-Host "      Fast-forward merge (no differences)" -ForegroundColor Green
    }

    Write-Host ""
    $i++
}

Write-Host "═══════════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "Analysis complete!" -ForegroundColor Green
Write-Host ""
Write-Host "To investigate a specific merge further, use:" -ForegroundColor Yellow
Write-Host '  git show --cc MERGE_HASH' -ForegroundColor White
Write-Host '  git diff PARENT1 PARENT2 file.php' -ForegroundColor White
Write-Host ""
