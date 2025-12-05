<?php
// Configuration pour s'assurer que PHP affiche les erreurs (partie du chaos)
error_reporting(E_ALL);
ini_set('display_errors', 0); // On cache les vraies erreurs pour le rendu HTML

session_start();

/**
 * =================================================================================
 * FRAMEWORK "OVER-ENGINEERED" V1.0
 * =================================================================================
 * Pourquoi faire simple quand on peut faire compliqué ?
 */

// Interface pour tout composant de notre machine
interface GearInterface {
    public function spin(Payload $payload): Payload;
}

// Objet transportant la donnée (la balle qui roule)
class Payload {
    private $data;
    private $logs = [];
    private $history = [];

    public function __construct($data) {
        $this->data = $data;
        $this->addLog("INFO", "Création du Payload avec la donnée brute : " . htmlspecialchars((string)$data));
    }

    public function getData() { return $this->data; }
    public function setData($data) { 
        $this->history[] = $this->data;
        $this->data = $data; 
    }
    
    public function addLog($level, $message) {
        $timestamp = date("H:i:s.u");
        $this->logs[] = ['time' => $timestamp, 'level' => $level, 'msg' => $message];
    }

    public function getLogs() { return $this->logs; }
    public function getHistory() { return $this->history; }
}

// Singleton pour gérer la gravité (essentiel pour une machine physique virtuelle)
class GravityManager {
    private static $instance = null;
    private $gravitationalConstant = 9.81;

    private function __construct() {}

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new GravityManager();
        }
        return self::$instance;
    }

    public function applyGravity() {
        // Simule une pause due à la friction de l'air
        usleep(rand(100000, 300000)); 
        return true;
    }
}

// ---------------------------------------------------------------------------------
// LES ENGRENAGES (LES ÉTAPES)
// ---------------------------------------------------------------------------------

// Étape 1 : Le Validateur Quantique (Vérifie si c'est un nombre)
class QuantumSanitizer implements GearInterface {
    public function spin(Payload $payload): Payload {
        $data = $payload->getData();
        GravityManager::getInstance()->applyGravity();
        
        $payload->addLog("PROCESS", "Initialisation du flux de sanitisation quantique...");
        
        // Méthode Rube Goldberg pour vérifier is_numeric :
        // On convertit en tableau, on inverse, on encode en JSON, on décode, on vérifie.
        $arr = str_split((string)$data);
        $reversed = array_reverse($arr);
        $json = json_encode($reversed);
        $decoded = json_decode($json);
        
        if (!is_numeric($data)) {
            $payload->addLog("ERROR", "Détection d'anomalie non-numérique dans le secteur 7G.");
            throw new Exception("Ceci n'est pas un nombre ! La machine s'est coincée.");
        }

        $payload->addLog("SUCCESS", "Donnée stabilisée. Conversion en Entier Integer 64-bit simulé.");
        $payload->setData((int)$data);
        return $payload;
    }
}

// Étape 2 : Le Calculateur Cosmique (fait des maths pour rien)
class CosmicCalculator implements GearInterface {
    public function spin(Payload $payload): Payload {
        $num = $payload->getData();
        GravityManager::getInstance()->applyGravity();

        $payload->addLog("PROCESS", "Alignement des matrices de calcul sur les constantes universelles...");
        
        $cosmicFluctuation = rand(1000000, 9999999);
        $payload->addLog("MATH", "Ajout d'une fluctuation cosmique de +{$cosmicFluctuation}.");
        
        $tempNum = $num + $cosmicFluctuation;

        $payload->addLog("MATH", "Recalibration en soustrayant la fluctuation cosmique...");
        $finalNum = $tempNum - $cosmicFluctuation;

        $payload->addLog("SUCCESS", "Le nombre a été vérifié par rapport aux constantes de l'univers. Il est stable.");
        return $payload;
    }
}

// Étape 3 : La Cuve de Clonage Moléculaire
class CloningVat implements GearInterface {
    public function spin(Payload $payload): Payload {
        $num = $payload->getData();
        GravityManager::getInstance()->applyGravity();

        $payload->addLog("PROCESS", "Analyse de la structure atomique du nombre...");

        if (rand(1, 5) === 1) { // 1 chance sur 5 de cloner
            $payload->addLog("WARN", "Instabilité détectée ! Le nombre se duplique !");
            $newNum = $num * 2;
            $payload->setData($newNum);
            $payload->addLog("SUCCESS", "Le nombre a été cloné avec succès. Nouvelle valeur : {$newNum}.");
        } else {
            $payload->addLog("INFO", "La structure du nombre est restée stable. Aucun clonage nécessaire.");
        }
        return $payload;
    }
}

// Étape 4 : L'Intelligence Artificielle "Deep Thought"
class DeepThoughtAI implements GearInterface {
    public function spin(Payload $payload): Payload {
        $payload->addLog("AI_BOOT", "Démarrage du réseau neuronal (1 neurone détecté)...");
        GravityManager::getInstance()->applyGravity();

        $guesses = ['Pair', 'Impair', 'Peut-être', '42', 'Chat'];
        $prediction = $guesses[array_rand($guesses)];
        
        $payload->addLog("AI_THINK", "L'IA analyse les vibrations cosmiques...");
        usleep(400000); // L'IA réfléchit très fort
        
        $payload->addLog("AI_RESULT", "Prédiction de l'IA : Le nombre semble être '$prediction'. (Confiance: " . rand(1, 99) . "%)");
        
        if ($prediction === 'Chat') {
            $payload->addLog("WARN", "Alerte : présence féline détectée dans les rouages.");
            if (rand(1, 10) === 1) { // 1 chance sur 10
                $payload->addLog("ERROR", "Le chat a provoqué un court-circuit existentiel !");
                throw new Exception("Erreur fatale : un chat s'est couché sur le mécanisme.");
            }
        }
        $payload->addLog("INFO", "Ignorance de la prédiction de l'IA par sécurité.");
        return $payload;
    }
}

// Étape 5 : Le Convertisseur Binaire Hydropneumatique
class BinaryConverterGear implements GearInterface {
    public function spin(Payload $payload): Payload {
        $num = $payload->getData();
        $binary = decbin($num);
        
        $payload->addLog("MECHANIC", "Activation de la presse hydraulique à bits.");
        $payload->addLog("DATA", "Représentation binaire : " . $binary);
        
        // On ne regarde que le dernier bit, mais on le fait de manière compliquée
        $lastBit = substr($binary, -1);
        
        // Stockage temporaire dans une session cryptée (simulation)
        $encryptedBit = base64_encode($lastBit);
        $payload->setData($encryptedBit);
        
        $payload->addLog("INFO", "Le dernier bit a été extrait, crypté ($encryptedBit) et envoyé au tapis roulant.");
        return $payload;
    }
}

// Étape 6 : Le Juge Final (Décodeur)
class FinalJudgmentGear implements GearInterface {
    public function spin(Payload $payload): Payload {
        GravityManager::getInstance()->applyGravity();
        
        $encryptedBit = $payload->getData();
        $bit = base64_decode($encryptedBit);
        
        $result = ($bit === '0') ? "PAIR" : "IMPAIR";
        
        $emoji = ($result === "PAIR") ? "⚖️" : "🦄";
        
        $payload->addLog("FINISH", "Analyse terminée. Libération des ballons.");
        $payload->setData("$emoji $result $emoji");
        
        return $payload;
    }
}

// ---------------------------------------------------------------------------------
// LE MOTEUR PRINCIPAL
// ---------------------------------------------------------------------------------

class RubeGoldbergMachine {
    private $gears = [];

    public function addGear(GearInterface $gear) {
        $this->gears[] = $gear;
    }

    public function run($inputValue) {
        $payload = new Payload($inputValue);
        
        try {
            foreach ($this->gears as $index => $gear) {
                $payload->addLog("SYSTEM", "--> Engagement de l'engrenage " . ($index + 1) . " : " . get_class($gear));
                $payload = $gear->spin($payload);
            }
        } catch (Exception $e) {
            $payload->addLog("CRITICAL_FAILURE", $e->getMessage());
            $payload->setData("ERREUR SYSTÈME");
        }
        
        $history = $payload->getHistory();
        $history[] = $payload->getData(); // Ajoute la valeur finale
        $historyString = implode(' -> ', array_map(function($val) {
            return is_string($val) ? '"' . htmlspecialchars($val) . '"' : htmlspecialchars($val);
        }, $history));
        $payload->addLog("SYSTEM", "Historique des transformations : " . $historyString);
        return $payload;
    }
}

// ---------------------------------------------------------------------------------
// TRAITEMENT DU FORMULAIRE
// ---------------------------------------------------------------------------------

$resultPayload = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['number'])) {
    $machine = new RubeGoldbergMachine();
    
    // Assemblage de la machine
    $machine->addGear(new QuantumSanitizer());     // Nettoie
    $machine->addGear(new CosmicCalculator());     // Calcule (pour rien)
    $machine->addGear(new CloningVat());           // Clone (parfois)
    $machine->addGear(new DeepThoughtAI());        // Réfléchit (sur le résultat du clonage)
    $machine->addGear(new BinaryConverterGear());  // Convertit en binaire
    $machine->addGear(new FinalJudgmentGear());    // Donne le verdict
    
    $resultPayload = $machine->run($_POST['number']);
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machine de Rube Goldberg PHP</title>
    <style>
        :root {
            --bg-color: #0d1117;
            --text-color: #c9d1d9;
            --accent-color: #58a6ff;
            --border-color: #30363d;
            --success: #2ea043;
            --warning: #d29922;
            --error: #f85149;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            width: 100%;
            max-width: 800px;
        }
        h1 {
            color: var(--accent-color);
            text-align: center;
            border-bottom: 2px dashed var(--border-color);
            padding-bottom: 10px;
        }
        .control-panel {
            background: #161b22;
            border: 1px solid var(--border-color);
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        input[type="text"] {
            background: #0d1117;
            border: 1px solid var(--border-color);
            color: #fff;
            padding: 10px;
            font-family: inherit;
            width: 60%;
            font-size: 1.2em;
        }
        button {
            background: var(--success);
            border: none;
            color: white;
            padding: 10px 20px;
            font-family: inherit;
            font-size: 1.2em;
            cursor: pointer;
            transition: transform 0.1s;
        }
        button:active { transform: scale(0.98); }
        
        .terminal {
            background: black;
            border: 4px solid #333;
            border-radius: 4px;
            padding: 15px;
            height: 400px;
            overflow-y: auto;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.8);
            position: relative;
        }
        .log-entry {
            margin-bottom: 5px;
            opacity: 0;
            animation: fadeIn 0.3s forwards;
            border-left: 3px solid transparent;
            padding-left: 8px;
        }
        .level-INFO { color: #8b949e; border-color: #8b949e; }
        .level-PROCESS { color: var(--accent-color); }
        .level-AI_THINK { color: #a371f7; font-style: italic; }
        .level-MATH { color: #f0a623; }
        .level-AI_RESULT { color: #a371f7; }
        .level-WARN { color: var(--warning); }
        .level-ERROR { color: var(--error); font-weight: bold; }
        .level-SUCCESS { color: var(--success); }
        .level-SYSTEM { color: #8b949e; }
        .level-FINISH { color: #fff; background: var(--success); display: inline-block; padding: 2px 5px;}

        .result-box {
            margin-top: 20px;
            text-align: center;
            font-size: 3em;
            font-weight: bold;
            color: #fff;
            text-shadow: 0 0 10px var(--accent-color);
            animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Animation delays for logs to simulate "processing" time in the browser */
        <?php 
        if ($resultPayload) {
            $count = 0;
            foreach ($resultPayload->getLogs() as $log) {
                echo ".log-id-$count { animation-delay: " . ($count * 0.15) . "s; }\n";
                $count++;
            }
            echo ".result-box { opacity: 0; animation: popIn 0.5s forwards; animation-delay: " . ($count * 0.15 + 0.5) . "s; }";
        }
        ?>

        @keyframes fadeIn { from { opacity: 0; transform: translateX(-10px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes popIn { from { opacity: 0; transform: scale(0.5); } to { opacity: 1; transform: scale(1); } }
    </style>
</head>
<body>

<div class="container">
    <h1>🏗️ Parity Validator 3000™</h1>
    
    <div class="control-panel">
        <form method="POST">
            <label for="number">Entrez un entier à analyser :</label><br><br>
            <input type="text" name="number" id="number" placeholder="ex: 42" autocomplete="off" required>
            <button type="submit">Lancer la Machine</button>
        </form>
    </div>

    <?php if ($resultPayload): ?>
        <div class="terminal">
            <?php 
            foreach ($resultPayload->getLogs() as $index => $log): ?>
                <div class="log-entry level-<?= $log['level'] ?> log-id-<?= $index ?>">
                    <span style="opacity:0.5">[<?= $log['time'] ?>]</span> 
                    <strong>[<?= $log['level'] ?>]</strong> 
                    <?= $log['msg'] ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="result-box">
            <?= $resultPayload->getData() ?>
        </div>
    <?php else: ?>
        <div class="terminal">
            <div class="log-entry level-INFO" style="animation:none; opacity:1;">
                [SYSTEM] En attente de l'input utilisateur...<br>
                [SYSTEM] Graissage des rouages...<br>
                [SYSTEM] Prêt.
            </div>
        </div>
    <?php endif; ?>

    <p style="text-align:center; font-size:0.8em; color:#666; margin-top:20px;">
        Propulsé par PHP <?= phpversion() ?> et beaucoup trop de classes.
    </p>
    <p style="text-align:center; font-size:0.8em; color:#666;">
        Libre de droit et fait par Boussou Jarlin.
    </p>
</div>

<script>
    // Petit script pour scroller automatiquement le terminal vers le bas au fur et à mesure que les logs apparaissent
    const terminal = document.querySelector('.terminal');
    if(terminal) {
        let count = 0;
        const interval = setInterval(() => {
            terminal.scrollTop = terminal.scrollHeight;
            count++;
            if(count > 50) clearInterval(interval); // Arrêt de sécurité
        }, 150);
    }
</script>

</body>
</html>