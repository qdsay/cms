<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * QD captcha
 *
 * Security Code requires authentication code text twist, rotate,
 * using different fonts, add the interference code.
 *
 */
class Captcha {

    private $ci;

    /**
     * Session code
     * Session subscript of the verifycode
     * Verify code expirations time(s)
     */
    private $code = "";
    private $sessKey = 'captcha.qdsay.com';
    private $expiration = 3000;

    /**
    * The characters used in verification code, 01IO confusing, do not recommend a
    */
    private $codeSet = 'bcdefghigkmnprstuvwxy34678ABCDEFGHJKLMNPQRTUVWXY';
    private $fontsize = 20;     // Verify code font size(px)
    private $height = 0;        // Verify code image height
    private $width = 0;         // Verify code image width
    private $length = 4;        // Length of the verify code
    private $bg = array(243, 251, 254); // background

    protected $image = NULL;   // Example image of the verify code
    protected $color = NULL;  // Font color of the verify code

    public function __construct($config = array()) {
        $this->ci =& get_instance();
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Create verify code
    */
    public function create() {
        //Image width(px)
        $this->width || $this->width = $this->length * $this->fontsize * 1.5 + $this->fontsize*1.5;
        //Image height(px)
        $this->height || $this->height = $this->fontsize * 2;
        // Create $this->width x $this->height image
        $this->image = imagecreate($this->width, $this->height);
        //Set the background
        imagecolorallocate($this->image, $this->bg[0], $this->bg[1], $this->bg[2]);
        //Random font color of the verify code
        $this->color = imagecolorallocate($this->image, mt_rand(156, 256), mt_rand(156, 256), mt_rand(156, 256));
        //Set the border
        imagerectangle($this->image, 0, 0, $this->width - 1, $this->height - 1, $this->color);

        //Draw noise
        $this->writeNoise();
        //Drawn curve
        $this->writeCurve();
        //Drawn verify code
        $this->writeCode();
        //Save verify code
        $this->saveCode();

        //Output image
        imagepng($this->image);
        imagedestroy($this->image);
        $this->ci->output->set_content_type('png')->set_output($this->image);
    }

    /**
     * Save verify code
    */
    public function saveCode() {
        //Save verify code
        isset($_SESSION) || session_start();
        $_SESSION[$this->sessKey]['ip'] = $this->ci->input->ip_address();
        $_SESSION[$this->sessKey]['code'] = $this->code; //Verify code to save to the session
        $_SESSION[$this->sessKey]['time'] = time(); //Verify code created time
    }

    /**
     * Check verify code
    */
    public function check($code) {
        //Session start
        isset($_SESSION) || session_start();
        //Verify code can not be empty
        if(empty($code) || empty($_SESSION[$this->sessKey])) {
            return FALSE;
        }
        //client ip
        if($_SESSION[$this->sessKey]['ip'] != $this->ci->input->ip_address()) {
            return FALSE;
        }
        //session expired
        if(time() - $_SESSION[$this->sessKey]['time'] > $this->expiration) {
            unset($_SESSION[$this->sessKey]);
            return FALSE;
        }
        //session code
        if($code == strtolower($_SESSION[$this->sessKey]['code'])) {
            return true;
        }
 
        return FALSE;
    }

    /**
    * Draw code
    * Pictures of different colors to write the letters or numbers
    */
    protected function writeCode() {
        $code = array(); //Verify code
        $codeNX = 0;     //The left margin of verify code from the n characters
        for ($i = 0; $i<$this->length; $i++) {
            $code[$i] = $this->codeSet[mt_rand(20, 47)];
            $codeNX += mt_rand($this->fontsize*1.2, $this->fontsize*1.6);
            //Write a verify code character
            $fontColor = imagecolorallocate($this->image,mt_rand(0, 156),mt_rand(0, 156),mt_rand(0, 156));
            imagettftext($this->image, $this->fontsize, mt_rand(-40, 70), $codeNX, $this->fontsize*1.5, $fontColor, $this->randttf(), $code[$i]);
        }
        $this->code = join("", $code);
    }

    /**
     * Draw a two together constitute the sine curve for the random interference line (you can change more handsome curve  function)
     *
     * Sinusoidal analytic function：y=Asin(ωx+φ)+b
     * Parameter Description：
     * a：Decided to peak (ie, longitudinal tensile compression ratio)
     * y：That the position of the waveform between the Y axis or vertical distance (on the plus next less)
     * x：X-axis position of the waveform and determine relationships or lateral distance (left plus right-minus)
     * c：Decision cycle (the least positive period T = 2π / | ω |)
     *
     */
    protected function writeCurve() {
        $a = mt_rand(1, $this->height/2);                  //Amplitude
        $x = mt_rand(-$this->height/4, $this->height/4);   //X-axis offset
        $y = mt_rand(-$this->height/4, $this->height/4);   //Y-axis offset
        $c = mt_rand($this->height*1.5, $this->width*2);   //Cycle
        $w = (2* M_PI)/$c;
                       
        $px1 = 0; //Abscissa of the starting position curve
        $px2 = mt_rand($this->width/2, $this->width * 0.667); //End position curve abscissa          
        for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {
            if ($w!=0) {
                $py = $a * sin($w*$px + $x)+ $y + $this->height/2; // y = Asin(ωx+φ) + b
                $i = (int) (($this->fontsize - 6)/4);
                while ($i > 0) {  
                     imagesetpixel($this->image, $px + $i, $py + $i, $this->color); //This painting pixel performance  is better than a lot of imagettftext and imagestring              
                     $i--;
                }
            }
        }

        $a = mt_rand(1, $this->height/2);                  //Amplitude
        $x = mt_rand(-$this->height/4, $this->height/4);   //X-axis offset
        $c = mt_rand($this->height*1.5, $this->width*2);   //Cycle
        $w = (2* M_PI)/$c;      
        $y = $py - $a * sin($w*$px + $x) - $this->height/2;
        $px1 = $px2;
        $px2 = $this->width;
        for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {
            if ($w!=0) {
                $py = $a * sin($w*$px + $x)+ $y + $this->height/2; // y = Asin(ωx+φ) + b
                $i = (int) (($this->fontsize - 8)/4);
                while ($i > 0) {          
                     imagesetpixel($this->image, $px + $i, $py + $i, $this->color); //Here (while) loop drawing pixels  and imagestring than imagettftext a draw with the font size (not the while loop) performance is much  better
                     $i--;
                }
            }
        }
    }

    /**
    * Draw noise
    * Pictures of different colors to write the letters or numbers
    */
    protected function writeNoise() {
        for($i = 0; $i < 10; $i++){
            //Noise color
            $noiseColor = imagecolorallocate($this->image, mt_rand(150,225), mt_rand(150,225), mt_rand(150,225));
            for($j = 0; $j < 5; $j++) {
                //Draw noise
                imagestring($this->image, ceil($this->fontsize / 5), mt_rand(-10, $this->width), mt_rand(-10, $this->height), $this->codeSet[mt_rand(0, 24)], $noiseColor);
            }
        }
    }

    //Random font of the verify code
    public function randttf() {
        $fontdir = BASEPATH.'fonts/';
        if ($fp = @opendir($fontdir)) {
            $fonts = array();
            while (FALSE !== ($file = readdir($fp)))
            {
                if (strncmp($file, '.', 1) !== 0) {
                    $ext = pathinfo($fontdir . $file, PATHINFO_EXTENSION);
                    if (strtolower($ext) == "ttf") {
                        $fonts[] = $file;
                    }
                }
            }
            return BASEPATH.'fonts/'.$fonts[mt_rand(0, count($fonts) - 1)];
        }
        return BASEPATH.'fonts/texb.ttf';
    }
}

/* End of file captcha.php */
/* Location: ./application/controllers/login.php */