<?php

namespace Functions;

use Exception;
use Objects\Park;

class ParkSelector
{

    public static function calcularParkIdeal($valoresArray): ?Park
    {
        $parks = self::obterParks();
        $matrixSize = count($valoresArray);

        // Step 1: Pairwise comparison matrix
        $pairwiseMatrix = self::obterMatrizComparacaoParPares($valoresArray, $matrixSize);

        $bestPark = null;
        $bestScore = 0;

        foreach ($parks as $park) {
            try {
                // Step 2: Apply AHP algorithm for each park
                $parkID = $park->getId();
                $parkQualityValues = self::obterValoresDoPark($parkID);
                $result = self::ahp($valoresArray, $parks, $pairwiseMatrix, $parkQualityValues);

                // Step 3: Check if the current park has a higher score
                if ($result['score'] > $bestScore) {
                    $bestScore = $result['score'];
                    $bestPark = $park;
                }
            } catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }

        return $bestPark;
    }

    public static function obterMatrizComparacaoParPares($valoresArray, $matrixSize): array
    {
        $pairwiseMatrix = array_fill(0, $matrixSize, array_fill(0, $matrixSize, 1));

        // For each pair of criteria, use the user's input values from $valoresArray
        for ($i = 0; $i < $matrixSize; $i++) {
            for ($j = $i + 1; $j < $matrixSize; $j++) {
                // Use the user's input values directly from $valoresArray
                $importanceValue = $valoresArray[$i] / $valoresArray[$j];

                // Assign the importance value to the matrix and its reciprocal
                $pairwiseMatrix[$i][$j] = $importanceValue;
                $pairwiseMatrix[$j][$i] = 1 / $importanceValue;
            }
        }

        return $pairwiseMatrix;
    }

    public static function ahp($criteria, $alternatives, $pairwiseMatrix, $parkQualityValues): array
    {
        // Step 1: Normalize the pairwise matrix
        $normalizedMatrix = self::normalizeMatrix($pairwiseMatrix, count($criteria));

        // Step 2: Calculate the criteria weights
        $criteriaWeights = self::calculateWeights($normalizedMatrix, count($criteria));

        // Step 4: Calculate the alternative scores with park_quality values
        $alternativeScores = self::calculateAlternativeScoresWithQuality($normalizedMatrix, $criteriaWeights, count($alternatives), $parkQualityValues);

        // Step 5: Rank alternatives based on scores
        $rankedAlternatives = self::rankAlternatives($alternatives, $alternativeScores);

        // Return the result, including the score
        return ['park' => $rankedAlternatives[0], 'score' => $alternativeScores[0]];
    }

    public static function normalizeMatrix($matrix, $size): array
    {
        $normalizedMatrix = [];

        for ($i = 0; $i < $size; $i++) {
            $columnSum = array_sum(array_column($matrix, $i));

            for ($j = 0; $j < $size; $j++) {
                $normalizedMatrix[$i][$j] = $matrix[$i][$j] / $columnSum;
            }
        }

        return $normalizedMatrix;
    }

    public static function calculateWeights($matrix, $size): array
    {
        $weights = [];

        for ($i = 0; $i < $size; $i++) {
            $weights[$i] = array_sum($matrix[$i]) / $size;
        }

        return $weights;
    }

    public static function calculateAlternativeScoresWithQuality($matrix, $weights, $size, $parkQualityValues): array
    {
        $alternativeScores = [];

        for ($i = 0; $i < $size; $i++) {
            $alternativeScores[$i] = 0;

            for ($j = 0; $j < $size; $j++) {
                // Multiply the matrix value by the weight and park quality value
                $alternativeScores[$i] += $matrix[$j][$i] * $weights[$j] * $parkQualityValues[$j];
            }
        }

        return $alternativeScores;
    }

    public static function rankAlternatives($alternatives, $scores): array
    {
        // Create an associative array with park IDs as keys and scores as values
        $rankedAlternatives = array_combine(
            array_map(function ($park) {
                return $park->getId();
            }, $alternatives),
            $scores
        );

        // Sort the array in descending order based on scores
        arsort($rankedAlternatives);

        // Return the array with park IDs
        return array_keys($rankedAlternatives);
    }

    public static function obterParks(): array
    {
        $ret = array();
        $sql = "SELECT id FROM park";
        $query = Database::getConnection()->query($sql);
        if ($query->num_rows > 0) {
            while ($row = $query->fetch_array(MYSQLI_ASSOC)) {
                $ret[] = new Park($row["id"]);
            }
        }
        return $ret;
    }
    public static function obterValoresDoPark($parkID): array {
        $ret = array();
        $sql = "SELECT value FROM park_quality WHERE park_fk = '$parkID'";
        $query = Database::getConnection()->query($sql);
        if ($query->num_rows > 0) {
            while ($row = $query->fetch_array(MYSQLI_ASSOC)) {
                $ret[] = $row["value"];
            }
        }
        return $ret;
    }
}