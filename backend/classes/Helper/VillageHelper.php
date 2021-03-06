<?php

class VillageHelper
{
    public static function getExpansions($changePoints): array
    {
        $changePoints = intval($changePoints);

        if ($changePoints < 0) {
            $changePoints = -$changePoints;
        }
        return match ($changePoints) {
            10 => array(
                array(
                    "Hauptgebäude",
                    1
                ),
                array(
                    "Hauptgebäude",
                    11
                ),
                array(
                    "Stall",
                    7),
                array(
                    "Werkstatt",
                    6),
                array(
                    "Kirche",
                    1),
                array(
                    "Erste Kirche",
                    1),
                array(
                    "Wachturm",
                    3),
                array(
                    "Schmiede",
                    7),
                array(
                    "Markt",
                    1),
                array(
                    "Markt",
                    11)),
            2 => array(
                array(
                    "Hauptgebäude",
                    2),
                array(
                    "Hauptgebäude",
                    3),
                array(
                    "Kirche",
                    2),
                array(
                    "Kirche",
                    3),
                array(
                    "Markt",
                    2),
                array(
                    "Markt",
                    3),
                array(
                    "Holzfäller",
                    3),
                array(
                    "Holzfäller",
                    5),
                array(
                    "Lehmgrube",
                    3),
                array(
                    "Lehmgrube",
                    5),
                array(
                    "Eisenmine",
                    3),
                array(
                    "Eisenmine",
                    5),
                array(
                    "Bauernhof",
                    4),
                array(
                    "Bauernhof",
                    6),
                array(
                    "Speicher",
                    3),
                array(
                    "Speicher",
                    5),
                array(
                    "Versteck",
                    4),
                array(
                    "Versteck",
                    6),
                array(
                    "Wall",
                    2),
                array(
                    "Wall",
                    3),
                array(
                    "Wall",
                    4)),
            3 => array(
                array(
                    "Hauptgebäude",
                    4),
                array(
                    "Kaserne",
                    2),
                array(
                    "Markt",
                    4),
                array(
                    "Holzfäller",
                    6),
                array(
                    "Holzfäller",
                    7),
                array(
                    "Holzfäller",
                    8),
                array(
                    "Lehmgrube",
                    6),
                array(
                    "Lehmgrube",
                    7),
                array(
                    "Lehmgrube",
                    8),
                array(
                    "Eisenmine",
                    6),
                array(
                    "Eisenmine",
                    7),
                array(
                    "Eisenmine",
                    8),
                array(
                    "Bauernhof",
                    7),
                array(
                    "Bauernhof",
                    8),
                array(
                    "Bauernhof",
                    9),
                array(
                    "Speicher",
                    6),
                array(
                    "Speicher",
                    7),
                array(
                    "Speicher",
                    8),
                array(
                    "Versteck",
                    7),
                array(
                    "Versteck",
                    8),
                array(
                    "Versteck",
                    9),
                array(
                    "Wall",
                    5),
                array(
                    "Wall",
                    6)),
            4 => array(
                array(
                    "Hauptgebäude",
                    5),
                array(
                    "Hauptgebäude",
                    6),
                array(
                    "Kaserne",
                    3),
                array(
                    "Stall",
                    2),
                array(
                    "Schmiede",
                    2),
                array(
                    "Schmiede",
                    3),
                array(
                    "Markt",
                    5),
                array(
                    "Markt",
                    6),
                array(
                    "Wall",
                    7)),
            5 => array(
                array(
                    "Hauptgebäude",
                    7),
                array(
                    "Kaserne",
                    4),
                array(
                    "Kaserne",
                    5),
                array(
                    "Stall",
                    3),
                array(
                    "Werkstatt",
                    2),
                array(
                    "Markt",
                    7),
                array(
                    "Holzfäller",
                    9),
                array(
                    "Holzfäller",
                    10),
                array(
                    "Lehmgrube",
                    9),
                array(
                    "Lehmgrube",
                    10),
                array(
                    "Eisenmine",
                    9),
                array(
                    "Eisenmine",
                    10),
                array(
                    "Bauernhof",
                    1),
                array(
                    "Bauernhof",
                    10),
                array(
                    "Bauernhof",
                    11),
                array(
                    "Speicher",
                    9),
                array(
                    "Speicher",
                    10),
                array(
                    "Versteck",
                    1),
                array(
                    "Versteck",
                    10),
                array(
                    "Wall",
                    8),
                array(
                    "Wall",
                    9)),
            6 => array(
                array(
                    "Hauptgebäude",
                    8),
                array(
                    "Stall",
                    4),
                array(
                    "Stall",
                    5),
                array(
                    "Werkstatt",
                    3),
                array(
                    "Werkstatt",
                    4),
                array(
                    "Schmiede",
                    4),
                array(
                    "Schmiede",
                    5),
                array(
                    "Markt",
                    8),
                array(
                    "Holzfäller",
                    1),
                array(
                    "Holzfäller",
                    11),
                array(
                    "Lehmgrube",
                    1),
                array(
                    "Lehmgrube",
                    11),
                array(
                    "Eisenmine",
                    1),
                array(
                    "Eisenmine",
                    11),
                array(
                    "Bauernhof",
                    12),
                array(
                    "Speicher",
                    1),
                array(
                    "Speicher",
                    11)),
            7 => array(
                array(
                    "Hauptgebäude",
                    9),
                array(
                    "Kaserne",
                    6),
                array(
                    "Markt",
                    9),
                array(
                    "Wall",
                    10)),
            9 => array(
                array(
                    "Hauptgebäude",
                    10),
                array(
                    "Kaserne",
                    8),
                array(
                    "Stall",
                    6),
                array(
                    "Werkstatt",
                    5),
                array(
                    "Markt",
                    10),
                array(
                    "Wall",
                    11),
                array(
                    "Wall",
                    12)),
            12 => array(
                array(
                    "Hauptgebäude",
                    12),
                array(
                    "Kaserne",
                    9),
                array(
                    "Stall",
                    8),
                array(
                    "Werkstatt",
                    7),
                array(
                    "Markt",
                    12),
                array(
                    "Wall",
                    13)),
            15 => array(
                array(
                    "Hauptgebäude",
                    13),
                array(
                    "Markt",
                    13),
                array(
                    "Holzfäller",
                    16),
                array(
                    "Lehmgrube",
                    16),
                array(
                    "Eisenmine",
                    16),
                array(
                    "Bauernhof",
                    17),
                array(
                    "Speicher",
                    16),
                array(
                    "Wall",
                    14)),
            18 => array(
                array(
                    "Hauptgebäude",
                    14),
                array(
                    "Wachturm",
                    6),
                array(
                    "Markt",
                    14)),
            21 => array(
                array(
                    "Hauptgebäude",
                    15),
                array(
                    "Stall",
                    11),
                array(
                    "Werkstatt",
                    10),
                array(
                    "Markt",
                    15)),
            26 => array(
                array(
                    "Hauptgebäude",
                    16),
                array(
                    "Markt",
                    16)),
            31 => array(
                array(
                    "Hauptgebäude",
                    17),
                array(
                    "Wachturm",
                    9),
                array(
                    "Markt",
                    17)),
            37 => array(
                array(
                    "Hauptgebäude",
                    18),
                array(
                    "Markt",
                    18)),
            44 => array(
                array(
                    "Hauptgebäude",
                    19),
                array(
                    "Markt",
                    19)),
            55 => array(
                array(
                    "Hauptgebäude",
                    20),
                array(
                    "Markt",
                    20)),
            64 => array(
                array(
                    "Hauptgebäude",
                    21),
                array(
                    "Markt",
                    21)),
            77 => array(
                array(
                    "Hauptgebäude",
                    22),
                array(
                    "Markt",
                    22)),
            92 => array(
                array(
                    "Hauptgebäude",
                    23),
                array(
                    "Markt",
                    23)),
            110 => array(
                array(
                    "Hauptgebäude",
                    24),
                array(
                    "Markt",
                    24)),
            133 => array(
                array(
                    "Hauptgebäude",
                    25),
                array(
                    "Markt",
                    25)),
            159 => array(
                array(
                    "Hauptgebäude",
                    26)),
            191 => array(
                array(
                    "Hauptgebäude",
                    27)),
            229 => array(
                array(
                    "Hauptgebäude",
                    28)),
            274 => array(
                array(
                    "Hauptgebäude",
                    29)),
            330 => array(
                "Hauptgebäude",
                30),
            16 => array(
                array(
                    "Kaserne",
                    1),
                array(
                    "Kaserne",
                    11),
                array(
                    "Schmiede",
                    10)),
            8 => array(
                array(
                    "Kaserne",
                    7),
                array(
                    "Wachturm",
                    2),
                array(
                    "Schmiede",
                    6),
                array(
                    "Holzfäller",
                    12),
                array(
                    "Holzfäller",
                    13),
                array(
                    "Lehmgrube",
                    12),
                array(
                    "Lehmgrube",
                    13),
                array(
                    "Eisenmine",
                    12),
                array(
                    "Eisenmine",
                    13),
                array(
                    "Bauernhof",
                    13),
                array(
                    "Bauernhof",
                    14),
                array(
                    "Speicher",
                    12),
                array(
                    "Speicher",
                    13),
                array(
                    "Wall",
                    1)),
            14 => array(
                array(
                    "Kaserne",
                    10),
                array(
                    "Stall",
                    9),
                array(
                    "Werkstatt",
                    8),
                array(
                    "Wachturm",
                    5),
                array(
                    "Schmiede",
                    9)),
            20 => array(
                array(
                    "Kaserne",
                    12),
                array(
                    "Stall",
                    1),
                array(
                    "Wachturm",
                    7),
                array(
                    "Schmiede",
                    11),
                array(
                    "Wall",
                    16)),
            24 => array(
                array(
                    "Kaserne",
                    13),
                array(
                    "Werkstatt",
                    1),
                array(
                    "Statue",
                    1)),
            28 => array(
                array(
                    "Kaserne",
                    14),
                array(
                    "Schmiede",
                    13)),
            34 => array(
                array(
                    "Kaserne",
                    15),
                array(
                    "Schmiede",
                    14)),
            42 => array(
                array(
                    "Kaserne",
                    16),
                array(
                    "Wachturm",
                    1)),
            49 => array(
                array(
                    "Kaserne",
                    17),
                array(
                    "Schmiede",
                    16)),
            59 => array(
                array(
                    "Kaserne",
                    18)),
            71 => array(
                array(
                    "Kaserne",
                    19),
                array(
                    "Schmiede",
                    18)),
            85 => array(
                array(
                    "Kaserne",
                    20)),
            102 => array(
                array(
                    "Kaserne",
                    21)),
            123 => array(
                array(
                    "Kaserne",
                    22)),
            147 => array(
                array(
                    "Kaserne",
                    23)),
            177 => array(
                array(
                    "Kaserne",
                    24)),
            212 => array(
                array(
                    "Kaserne",
                    25)),
            17 => array(
                array(
                    "Stall",
                    10),
                array(
                    "Werkstatt",
                    9),
                array(
                    "Wall",
                    15)),
            25 => array(
                array(
                    "Stall",
                    12),
                array(
                    "Werkstatt",
                    11),
                array(
                    "Wachturm",
                    8),
                array(
                    "Wall",
                    17)),
            29 => array(
                array(
                    "Stall",
                    13),
                array(
                    "Werkstatt",
                    12),
                array(
                    "Wall",
                    18)),
            36 => array(
                array(
                    "Stall",
                    14),
                array(
                    "Werkstatt",
                    13),
                array(
                    "Wachturm",
                    10),
                array(
                    "Wall",
                    19)),
            43 => array(
                array(
                    "Stall",
                    15),
                array(
                    "Werkstatt",
                    14),
                array(
                    "Wachturm",
                    11),
                array(
                    "Wall",
                    20)),
            51 => array(
                array(
                    "Stall",
                    16),
                array(
                    "Werkstatt",
                    15)),
            62 => array(
                array(
                    "Stall",
                    17),
                array(
                    "Wachturm",
                    13)),
            74 => array(
                array(
                    "Stall",
                    18)),
            88 => array(
                array(
                    "Stall",
                    19)),
            107 => array(
                array(
                    "Stall",
                    20)),
            13 => array(
                array(
                    "Wachturm",
                    4),
                array(
                    "Holzfäller",
                    15),
                array(
                    "Lehmgrube",
                    15),
                array(
                    "Eisenmine",
                    15),
                array(
                    "Bauernhof",
                    16),
                array(
                    "Speicher",
                    15)),
            52 => array(
                array(
                    "Wachturm",
                    12)),
            75 => array(
                array(
                    "Wachturm",
                    14)),
            90 => array(
                array(
                    "Wachturm",
                    15)),
            108 => array(
                array(
                    "Wachturm",
                    16)),
            130 => array(
                array(
                    "Wachturm",
                    17)),
            155 => array(
                array(
                    "Wachturm",
                    18)),
            186 => array(
                array(
                    "Wachturm",
                    19)),
            224 => array(
                array(
                    "Wachturm",
                    20)),
            512 => array(
                array(
                    "Adelshof",
                    1)),
            19 => array(
                array(
                    "Schmiede",
                    1),
                array(
                    "Holzfäller",
                    17),
                array(
                    "Lehmgrube",
                    17),
                array(
                    "Eisenmine",
                    17),
                array(
                    "Bauernhof",
                    18),
                array(
                    "Speicher",
                    17)),
            11 => array(
                array(
                    "Schmiede",
                    8),
                array(
                    "Holzfäller",
                    14),
                array(
                    "Lehmgrube",
                    14),
                array(
                    "Eisenmine",
                    14),
                array(
                    "Bauernhof",
                    15),
                array(
                    "Speicher",
                    14)),
            23 => array(
                array(
                    "Schmiede",
                    12)),
            41 => array(
                array(
                    "Schmiede",
                    15)),
            58 => array(
                array(
                    "Schmiede",
                    17)),
            84 => array(
                array(
                    "Schmiede",
                    19)),
            101 => array(
                array(
                    "Schmiede",
                    20)),
            1 => array(
                array(
                    "Holzfäller",
                    2), array(
                    "Holzfäller",
                    4),
                array(
                    "Lehmgrube",
                    2),
                array(
                    "Lehmgrube",
                    4),
                array(
                    "Eisenmine",
                    2),
                array(
                    "Eisenmine",
                    4),
                array(
                    "Bauernhof",
                    2),
                array(
                    "Bauernhof",
                    3),
                array(
                    "Bauernhof",
                    5),
                array(
                    "Speicher",
                    2),
                array(
                    "Speicher",
                    4),
                array(
                    "Versteck",
                    2),
                array(
                    "Versteck",
                    3),
                array(
                    "Versteck",
                    5)),
            22 => array(
                array(
                    "Holzfäller",
                    18),
                array(
                    "Lehmgrube",
                    18),
                array(
                    "Eisenmine",
                    18),
                array(
                    "Bauernhof",
                    19),
                array(
                    "Speicher",
                    18)),
            27 => array(
                array(
                    "Holzfäller",
                    19),
                array(
                    "Lehmgrube",
                    19),
                array(
                    "Eisenmine",
                    19),
                array(
                    "Bauernhof",
                    20),
                array(
                    "Speicher",
                    19)),
            32 => array(
                array(
                    "Holzfäller",
                    20),
                array(
                    "Lehmgrube",
                    20),
                array(
                    "Eisenmine",
                    20),
                array(
                    "Bauernhof",
                    21),
                array(
                    "Speicher",
                    20)),
            38 => array(
                array(
                    "Holzfäller",
                    21),
                array(
                    "Lehmgrube",
                    21),
                array(
                    "Eisenmine",
                    21)),
            38 => array(
                array(
                    "Bauernhof",
                    22),
                array(
                    "Speicher",
                    21)),
            46 => array(
                array(
                    "Holzfäller",
                    22),
                array(
                    "Lehmgrube",
                    22),
                array(
                    "Eisenmine",
                    22),
                array(
                    "Bauernhof",
                    23),
                array(
                    "Speicher",
                    22)),
            55 => array(
                array(
                    "Holzfäller",
                    23),
                array(
                    "Lehmgrube",
                    23),
                array(
                    "Eisenmine",
                    23),
                array(
                    "Bauernhof",
                    24),
                array(
                    "Speicher",
                    23)),
            66 => array(
                array(
                    "Holzfäller",
                    24),
                array(
                    "Lehmgrube",
                    24),
                array(
                    "Eisenmine",
                    24),
                array(
                    "Bauernhof",
                    25),
                array(
                    "Speicher",
                    24)),
            80 => array(
                array(
                    "Holzfäller",
                    25),
                array(
                    "Lehmgrube",
                    25),
                array(
                    "Eisenmine",
                    25),
                array(
                    "Bauernhof",
                    26),
                array(
                    "Speicher",
                    25)),
            95 => array(
                array(
                    "Holzfäller",
                    26),
                array(
                    "Lehmgrube",
                    26),
                array(
                    "Eisenmine",
                    26),
                array(
                    "Bauernhof",
                    27),
                array(
                    "Speicher",
                    26)),
            115 => array(
                array(
                    "Holzfäller",
                    27),
                array(
                    "Lehmgrube",
                    27),
                array(
                    "Eisenmine",
                    27),
                array(
                    "Bauernhof",
                    28),
                array(
                    "Speicher",
                    27)),
            137 => array(
                array(
                    "Holzfäller",
                    28),
                array(
                    "Lehmgrube",
                    28),
                array(
                    "Eisenmine",
                    28),
                array(
                    "Bauernhof",
                    29),
                array(
                    "Speicher",
                    28),
                array(
                    "Holzfäller",
                    29)),
            165 => array(
                array(
                    "Lehmgrube",
                    29),
                array(
                    "Eisenmine",
                    29),
                array(
                    "Bauernhof",
                    30),
                array(
                    "Speicher",
                    29)),
            198 => array(
                array(
                    "Holzfäller",
                    30),
                array(
                    "Lehmgrube",
                    30),
                array(
                    "Eisenmine",
                    30),
                array(
                    "Speicher",
                    30)),
            default => array(),
        };

    }
}