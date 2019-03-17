<?php

/**
 * Classe dei log ( SINGLETON )
 * @todo Creare le Child Class
 * @todo implementare la possibilità di salvare i dati anche in formato: txt e xml
 */
class Log
{

    private static $obj;

    private static $baseURL;

    private static $annoCorrente;

    private static $meseCorrente;

    private $filename;

    private static $maxFileNumber = 0;

    private static $arrayOfArr = [];



    private final function __construct() {

        self::$baseURL = $_SERVER['DOCUMENT_ROOT'] . '/login-system/'; // C:/xampp/htdocs

        self::$annoCorrente = date("y"); // 19

        self::$meseCorrente = date("m"); // 01
    }



    public static function setSingleton() { // $obj1 = DBConn::setSingleton();

        if(!isset(self::$obj)) {

            $class = __CLASS__;
            // la prima e unica volta che viene richiamata la classe viene inizializzata la variabile $obj
            // e viene richiamato per la prima e unica volta anche il costruttore
            self::$obj = new $class;
        }
        self::$arrayOfArr = [];
        return self::$obj;
    }


    /**
     * Crea log degli errori
     * @var string $directory - la directory dove verrà creato/aggiornato il file di log. Es.: C:/xampp/htdocs/login-system/logs/error/19/03
     * @param string $kind - il tipo di log. E' utilizzato per creare una sottocartella di logs. In questo caso è 'logs/error'
     * @param array $data - array di dati che viene ottenuto dalla classe MyException
     * @return void
     */
    public function createLogError(string $kind, array $data) {

        $this->createLog($kind, $data);
    }



    public function createLogUser(string $kind, array $data) {

    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
        $data['device'] = 'mobile';
    } else { $data['device'] = 'desktop'; }

    $data['ip'] = $_SERVER['REMOTE_ADDR'];

        $this->createLog($kind, $data);
    }

    /**
     * Crea log per salvare i tempi di esecuzione del codice
     * @var string $directory - la directory dove verrà creato/aggiornato il file di log. Es.: C:/xampp/htdocs/login-system/logs/error/19/03
     * @param string $kind - il tipo di log. E' utilizzato per creare una sottocartella di logs. In questo caso è 'logs/perf'
     * @param string $diff - un numero float. Minore è il suo valore e maggiore è la velocità di esecuzione del codice
     * @return void
     */
    public function createLogPerf(string $kind, string $diff) {  // logger.debug("Controller ‘home’ loaded in " . $mark->diff() . "ms";

        $datatime = date('Y-m-d H:i:s');

        $data = ['diff' => $diff, 'data' => $datatime];

        $this->createLog($kind, $data);
    }



    private function createLog(string $kind, array $data) {

        $directory = self::$baseURL . 'logs/' . $kind . '/' . self::$annoCorrente . '/' . self::$meseCorrente;

        $return = $this->createPathIfNotExists($directory);

        if ( is_null($return) ) {

            $this->searchFilename($directory);
            $this->checkSizeOfFile();
        }

        $this->handleJsonFile($data);
    }



    /**
     * Crea in automatico le directory e sotto directory per i file log
     * Se non esistono le directory di cartelle che dovranno contenere i log (logs/error/19/03)
     * allora verrà creata e il primo file log avrà nel nome il valore 0. Es.: log_0.json [A]
     * @param string $directory
     * @return void
     */
    private function createPathIfNotExists(string $directory) {

        if (is_dir($directory)) { return;}

        mkdir($directory, 0777, TRUE);

        $file_json = '/log_0.json'; // [A]

        $this->filename = $directory . $file_json; // logs/error/19/03/log_0.json

        return true;
    }



    /**
     * Se esistono le directory di cartelle allora sono state create in precedenza 
     * e dentro la cartella troveremo almeno un file log
     *
     * @var $files - è un array di tutti i file presenti nella directory,
     * viene ciclato cercando il file che ha il numero più grande nel suo nome. [B]
     * perchè si deve aggiornare l'ultimo file che è stato creato in precedenza.
     * Alla fine viene ricostruito il filename con il file da aggiornare. [C]
     * @param string $directory
     * @return void
     */
    private function searchFilename(string $directory) {

        $files = scandir($directory);

        foreach($files as $file) {

            if (preg_match('/[0-9]{1,3}/', $file, $numbers)) {

                self::$maxFileNumber = self::$maxFileNumber < intval($numbers[0]) ? intval($numbers[0]) : self::$maxFileNumber; // [B]
            }
        }

        $file_json = '/log_' . self::$maxFileNumber . '.json'; // [C]

        $this->filename = $directory . $file_json; // [C]
    }



    /**
     * Otteniamo il contenuto del file convertendolo in array. [Y]
     * se il file da aggiornare è troppo pesante o l' array è troppo lungo: [E]
     * dovrà essere creato un nuovo file per poi aggiornarlo
     * Quindi verrà creato un array vuoto per il nuovo file che dovrà contenere i dati presenti e futuri. [X]
     * Il nuovo file che non esiste ancora, dovrà avere il numero nel suo nome incrementato di 1,
     * se il file attuale si chiama 'log_5.json', allora il nuovo file si chiamerà 'log_6.json'. [D]
     * @var $arrayOfArr - Se è stato superato il controllo al punto [E] contiene i dati dei precedenti log
     * altrimenti sarà resettato a array vuoto. [M]
     * @return void
     */
    private function checkSizeOfFile() {

        $jsonstring = file_get_contents($this->filename); // [Y]

        $arrayOfArr = json_decode($jsonstring, true); // [Y]

        if(filesize($this->filename) > 1000 || count($arrayOfArr) > 2 ) { // [E]

            $arrayOfArr = array(); // [X] resettiamo l'array padre
            self::$maxFileNumber++;
            $file_json = '/log_' . self::$maxFileNumber . '.json'; // [D]
            $this->filename = $directory . $file_json;
        }
        self::$arrayOfArr = $arrayOfArr; // [M]
    }



    /**
     * $arrayOfArr può essere o un array vuoto perchè stiamo creando un nuovo file,
     * oppure è un array che contiene tutti i dati del file che sarà aggiornato. 
     * In ogni caso andremo ad appenderci i dati contenuti nell'array $data. [N]
     * Convertiamo l' array in formato json prima di inserirlo nel file. [O]
     * I dati in formato json vengono inseriti nel file. Se il file non esiste viene creato qui. [Z]
     * @param array $data
     * @return void
     */
    private function handleJsonFile(array $data) {

        self::$arrayOfArr[] = $data; // [N]

        $jsonstring = json_encode(self::$arrayOfArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // [O]

        file_put_contents($this->filename, $jsonstring); // [Z]
    }



} // EOC
