<?php

namespace App\Libraries;

class NoteCalculator
{
    public static function getScopes(): array
    {
        return [
            ['code' => 's3', 'label' => 'S3', 'semestres' => ['S3'], 'type' => 'semestre'],
            ['code' => 's4-dev', 'label' => 'S4 option dev', 'semestres' => ['S4 - Developpement'], 'type' => 'semestre'],
            ['code' => 's4-bddres', 'label' => 'S4 option bddres', 'semestres' => ['S4 - Bases de Donnees et Reseaux'], 'type' => 'semestre'],
            ['code' => 's4-web', 'label' => 'S4 option web', 'semestres' => ['S4 - Web et Design'], 'type' => 'semestre'],
            ['code' => 'l2-dev', 'label' => 'L2 option dev (S3 & S4 option dev)', 'semestres' => ['S3', 'S4 - Developpement'], 'type' => 'classe'],
            ['code' => 'l2-bddres', 'label' => 'L2 option bddres (S3 & S4 option bddres)', 'semestres' => ['S3', 'S4 - Bases de Donnees et Reseaux'], 'type' => 'classe'],
            ['code' => 'l2-web', 'label' => 'L2 option web (S3 & S4 option web)', 'semestres' => ['S3', 'S4 - Web et Design'], 'type' => 'classe'],
        ];
    }

    public static function getScopesFromSemestres(array $semestres): array
    {
        $scopes = [];
        $usedCodes = [];
        $s3ByClasse = [];
        $s4ByClasseOption = [];

        foreach ($semestres as $semestre) {
            $classeId = $semestre['id_classe'] ?? null;
            $optionId = $semestre['id_option'] ?? null;
            $nom = $semestre['nom'] ?? '';

            if ($classeId === null || $nom === '') {
                continue;
            }

            if (self::isSemestre3($nom)) {
                $s3ByClasse[$classeId] = $semestre;
            } else {
                $s4ByClasseOption[$classeId][$optionId] = $semestre;
            }
        }

        foreach ($semestres as $semestre) {
            $nom = $semestre['nom'] ?? '';
            if ($nom === '') {
                continue;
            }

            $optionName = $semestre['option_nom'] ?? '';
            if (self::isSemestre3($nom)) {
                $label = 'S3';
                $codeBase = 's3';
            } else {
                $label = $optionName === '' ? $nom : 'S4 option ' . $optionName;
                $codeBase = $optionName === '' ? 's4' : 's4-' . self::slugify($optionName);
            }

            $code = self::uniqueCode($codeBase, $usedCodes);
            $scopes[] = [
                'code' => $code,
                'label' => $label,
                'semestres' => [$nom],
                'type' => 'semestre',
            ];
        }

        foreach ($s4ByClasseOption as $classeId => $optionRows) {
            if (!isset($s3ByClasse[$classeId])) {
                continue;
            }

            $classeName = $s3ByClasse[$classeId]['classe_nom'] ?? '';
            $s3Nom = $s3ByClasse[$classeId]['nom'];

            foreach ($optionRows as $semestre) {
                $optionName = $semestre['option_nom'] ?? '';
                if ($optionName === '') {
                    continue;
                }

                $label = trim($classeName . ' option ' . $optionName);
                $label .= ' (S3 & S4 option ' . $optionName . ')';

                $codeBase = 'classe-' . self::slugify(trim($classeName . '-' . $optionName));
                $code = self::uniqueCode($codeBase, $usedCodes);

                $scopes[] = [
                    'code' => $code,
                    'label' => $label,
                    'semestres' => [$s3Nom, $semestre['nom']],
                    'type' => 'classe',
                ];
            }
        }

        usort($scopes, static function ($left, $right) {
            $typeOrder = ['semestre' => 0, 'classe' => 1];
            $leftOrder = $typeOrder[$left['type']] ?? 2;
            $rightOrder = $typeOrder[$right['type']] ?? 2;

            if ($leftOrder !== $rightOrder) {
                return $leftOrder <=> $rightOrder;
            }

            return strcmp($left['label'], $right['label']);
        });

        return $scopes;
    }

    public static function computeSemestreSummary(array $matieres, array $bestNotesMap, array $optionalGroups = []): array
    {
        $creditsTotal = 0;
        $sumPondere = 0.0;
        $matieresDetail = [];
        $lowNotes = 0;
        $notesCount = 0;
        $groupCredits = [];
        $matiereGroupMap = [];
        $groupBestMatiere = [];
        $groupCreditsAdded = [];

        foreach ($optionalGroups as $group) {
            $groupId = (int) ($group['id'] ?? 0);
            if ($groupId === 0) {
                continue;
            }

            $groupCredits[$groupId] = (int) ($group['credits'] ?? 0);
            $matiereIds = $group['matiere_ids'] ?? [];
            foreach ($matiereIds as $matiereId) {
                $matiereGroupMap[(int) $matiereId] = $groupId;
            }

            $bestNote = null;
            $bestMatiereId = null;
            foreach ($matiereIds as $matiereId) {
                $note = array_key_exists((int) $matiereId, $bestNotesMap) ? $bestNotesMap[(int) $matiereId] : null;
                if ($note === null) {
                    continue;
                }

                if ($bestNote === null || $note > $bestNote) {
                    $bestNote = $note;
                    $bestMatiereId = (int) $matiereId;
                }
            }

            if ($bestMatiereId !== null) {
                $groupBestMatiere[$groupId] = $bestMatiereId;
            }
        }

        foreach ($matieres as $matiere) {
            $matiereId = (int) $matiere['id'];
            $credits = (int) $matiere['credits'];
            $groupId = $matiereGroupMap[$matiereId] ?? null;
            $effectiveCredits = $groupId !== null ? ($groupCredits[$groupId] ?? $credits) : $credits;
            $isSelected = $groupId === null || (($groupBestMatiere[$groupId] ?? null) === $matiereId);
            $note = array_key_exists($matiereId, $bestNotesMap) ? $bestNotesMap[$matiereId] : null;

            if ($groupId === null) {
                $creditsTotal += $credits;
            } elseif (!isset($groupCreditsAdded[$groupId])) {
                $creditsTotal += $effectiveCredits;
                $groupCreditsAdded[$groupId] = true;
            }

            if ($isSelected && $note !== null) {
                $sumPondere += $note * $effectiveCredits;
                $notesCount++;
            }
            if ($isSelected && $note !== null && $note >= 6 && $note < 10) {
                $lowNotes++;
            }

            $matieresDetail[] = [
                'id' => $matiereId,
                'ue' => $matiere['ue'],
                'intitule' => $matiere['intitule'],
                'credits' => $credits,
                'note' => $note,
                'resultat' => '',
                'effective_credits' => $effectiveCredits,
                'is_selected' => $isSelected,
            ];
        }

        foreach ($matieresDetail as $index => $detail) {
            $note = $detail['note'];
            $resultat = '';

            if ($detail['is_selected'] && $note !== null) {
                if ($note >= 10) {
                    $resultat = self::mentionShort($note);
                } elseif ($note >= 6) {
                    $resultat = $lowNotes <= 2 ? 'Comp.' : '';
                }
            }

            $matieresDetail[$index]['resultat'] = $resultat;
        }

        $creditsGagnes = 0;
        foreach ($matieresDetail as $detail) {
            if ($detail['resultat'] !== '') {
                $creditsGagnes += $detail['effective_credits'];
            }
        }

        if ($notesCount === 0) {
            $moyenne = null;
            $mention = '';
            $resultat = '';
        } else {
            $moyenne = $creditsTotal > 0 ? round($sumPondere / $creditsTotal, 2) : null;
            $mention = $moyenne === null ? '' : self::mentionLong($moyenne);
            $resultat = $creditsTotal > 0 && $creditsGagnes === $creditsTotal ? 'Admis' : 'Ajournee';
        }

        return [
            'credits_total' => $creditsTotal,
            'credits_gagnes' => $creditsGagnes,
            'sum_ponderee' => $sumPondere,
            'moyenne' => $moyenne,
            'mention' => $mention,
            'resultat' => $resultat,
            'notes_count' => $notesCount,
            'matieres' => $matieresDetail,
        ];
    }

    public static function computeClasseSummary(array $semestreSummaries): array
    {
        $creditsTotal = 0;
        $creditsGagnes = 0;
        $sumPondere = 0.0;
        $notesCount = 0;

        foreach ($semestreSummaries as $summary) {
            $creditsTotal += $summary['credits_total'];
            $creditsGagnes += $summary['credits_gagnes'];
            $sumPondere += $summary['sum_ponderee'];
            $notesCount += $summary['notes_count'];
        }

        if ($notesCount === 0) {
            $moyenne = null;
            $mention = '';
            $resultat = '';
        } else {
            $moyenne = $creditsTotal > 0 ? round($sumPondere / $creditsTotal, 2) : null;
            $mention = $moyenne === null ? '' : self::mentionLong($moyenne);
            $resultat = ($creditsTotal > 0 && $creditsGagnes === $creditsTotal) ? 'Admis' : 'Ajournee';
        }

        return [
            'credits_total' => $creditsTotal,
            'credits_gagnes' => $creditsGagnes,
            'sum_ponderee' => $sumPondere,
            'moyenne' => $moyenne,
            'mention' => $mention,
            'resultat' => $resultat,
            'notes_count' => $notesCount,
        ];
    }

    private static function mentionShort(float $note): string
    {
        if ($note >= 16) {
            return 'TB';
        }
        if ($note >= 14) {
            return 'B';
        }
        if ($note >= 12) {
            return 'AB';
        }
        if ($note >= 10) {
            return 'P';
        }

        return '';
    }

    private static function mentionLong(float $note): string
    {
        if ($note >= 16) {
            return 'Tres-bien';
        }
        if ($note >= 14) {
            return 'Bien';
        }
        if ($note >= 12) {
            return 'Assez-bien';
        }
        if ($note >= 10) {
            return 'Passable';
        }

        return '';
    }

    private static function isSemestre3(string $nom): bool
    {
        return stripos($nom, 'S3') === 0;
    }

    private static function slugify(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9\s-]/', '', $value) ?? '';
        $value = preg_replace('/\s+/', '-', $value) ?? '';
        $value = preg_replace('/-+/', '-', $value) ?? '';

        return trim($value, '-');
    }

    private static function uniqueCode(string $base, array &$usedCodes): string
    {
        $code = $base;
        $index = 2;

        while (isset($usedCodes[$code])) {
            $code = $base . '-' . $index;
            $index++;
        }

        $usedCodes[$code] = true;

        return $code;
    }
}
