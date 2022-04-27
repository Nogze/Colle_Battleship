<?php

function display(array $grid, int $length, int $height) {

    /**
     * Affichage de la grille
     */

    $display = "+" . str_repeat("---+", $length) . PHP_EOL;

    for ($a = 0; $a < $height; $a++) {
        $display .= "|";
        for ($i = 0; $i < $length; $i++) {
            $display .= " " . $grid[$i][$a] . " |";
        }
        $display .= PHP_EOL . "+" . str_repeat("---+", $length) . PHP_EOL;
    }

    return $display;
}

function queryValidator(string $args, array $grid) {

    /**
     * On regarde si les coordonnées entrée correspondent
     * à un bateau l'emplacement d'un bateau
     */

    $parsedArgs = explode(",", substr($args, 1, strlen($args) - 2));
    return $grid[$parsedArgs[0]][$parsedArgs[1]] == "X";
}

function colle(int $x, int $y, array $coords) {

    if ($x == 0 || $y == 0) {
        return;
    }

    /**
    * Création de la grille sous forme d'array
    */

    $grid = [];

    for ($i = 0; $i < $x; $i++) {
        $grid[$i] = [];
        for ($a = 0; $a < $y; $a++) {
            $grid[$i][$a] = " ";
        }
    }

    // Récupération des coordonnées
    foreach ($coords as $value) {
            $grid[$value[0]][$value[1]] = "X";
    }

    // Affichage de la grille au début
    echo display($grid, $x, $y);

    /**
     * Prompt
     * Bonus :
     * - La commande "exit"
     * - La gestion d'erreur vite fait
     */

    $exit = false;

    while ($exit == false) {

        $commandsList = ["query", "add", "remove", "display", "exit"];
        $fullCommand = readline();

        if (count(explode(" ", $fullCommand)) > 1) {
            $command = explode(" ", $fullCommand)[0];
            $args = explode(" ", $fullCommand)[1];
        } else {
            $command = $fullCommand;
        }

        if (strlen($command) == 0) {
            continue;
        }

        if (!in_array($command, $commandsList)) {
            echo $command . ": command not found" . PHP_EOL;
            continue;
        }

        if (count(explode(" ", $fullCommand)) > 2) {
            echo $command . ": too many arguments specified" . PHP_EOL;
            continue;
        }

        switch($command) {
            case "query" :
                if(queryValidator($args, $grid)) {
                    echo "full" . PHP_EOL;
                }
                else {
                    echo "empty" . PHP_EOL;
                }
                break;
            case "add" :
                if(queryValidator($args, $grid)) {
                    echo "A cross already exists at this location" . PHP_EOL;
                }
                else {
                    $parsedArgs = explode(",", substr($args, 1, strlen($args) - 2));
                    $grid[$parsedArgs[0]][$parsedArgs[1]] = "X";
                    }
                break;
            case "remove" :
                if(queryValidator($args, $grid)) {
                    $parsedArgs = explode(",", substr($args, 1, strlen($args) - 2));
                    $grid[$parsedArgs[0]][$parsedArgs[1]] = " ";
                }
                else {
                    echo "No cross exists at this location" . PHP_EOL;
                    }
                break;
            case "display" :
                echo display($grid, $x, $y);
                break;
            case "exit" :
               $exit = true;
               break;
            default :
                break;
        }
    }
}

colle(4, 4, [[2,3], [1,1]]);