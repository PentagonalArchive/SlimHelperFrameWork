<?php
namespace Pentagonal\SlimHelper;

/**
 * Class ImageResize
 * @package Pentagonal\SlimHelper
 */
class ImageResize
{
    /**
     * List image type extension
     *
     * @var array
     */
    protected $image_type_list = [
        1 => [
            'IMAGETYPE_GIF',
            'gif'
        ],
        2 => [
            'IMAGETYPE_JPEG',
            'jpg'
        ],
        3 => [
            'IMAGETYPE_PNG',
            'png'
        ],
        4 => [
            'IMAGETYPE_SWF',
            'swf'
        ],
        5 => [
            'IMAGETYPE_PSD',
            'psd'
        ],
        6 => [
            'IMAGETYPE_BMP',
            'bmp'
        ],
        7 => [
            'IMAGETYPE_TIFF_II',
            'tiff'
        ],
        8 => [
            'IMAGETYPE_TIFF_MM',
            'tiff'
        ],
        9  => [
            'IMAGETYPE_JPC',
            'jpc'
        ],
        10 => [
            'IMAGETYPE_JP2',
            'jp2'
        ],
        11 => [
            'IMAGETYPE_JPX',
            'jpx'
        ],
        12 => [
            'IMAGETYPE_JB2',
            'jb2',
        ],
        13 => [
            'IMAGETYPE_SWC',
            'swc'
        ],
        14 => [
            'IMAGETYPE_IFF',
            'iff'
        ],
        15 => [
            'IMAGETYPE_WBMP',
            'bmp'
        ],
        16 => [
            'IMAGETYPE_XBM',
            'xbm'
        ],
        17 => [
            'IMAGETYPE_ICO',
            'ico'
        ],
    ];

    /**
     * list functions uses
     *
     * @var array
     */
    protected $image_type_function = [
        'IMAGETYPE_GIF' => 'imagecreatefromgif',
        'IMAGETYPE_JPEG' => 'imagecreatefromjpeg',
        'IMAGETYPE_PNG' => 'imagecreatefrompng',
        'IMAGETYPE_SWF' => 'class:imagick',
        'IMAGETYPE_PSD' => 'class:imagick',
        'IMAGETYPE_BMP' => 'imagecreatefromwbmp',
        'IMAGETYPE_TIFF_II' => 'class:imagick',
        'IMAGETYPE_TIFF_MM' => 'class:imagick',
        'IMAGETYPE_JPC' => 'class:imagick',
        'IMAGETYPE_JP2' => 'class:imagick',
        'IMAGETYPE_JPX' => 'class:imagick',
        'IMAGETYPE_JB2' => 'class:imagick',
        'IMAGETYPE_SWC' => 'class:imagick',
        'IMAGETYPE_IFF' => 'class:imagick',
        'IMAGETYPE_WBMP' => 'imagecreatefromwbmp',
        'IMAGETYPE_XBM' => 'imagecreatefromxbm',
        'IMAGETYPE_ICO' => 'class:imagick'
    ];

    const KEY_HEIGHT = 'height';
    const KEY_WIDTH  = 'width';
    const KEY_MODE   = 'mode';
    const KEY_PATH   = 'path';
    const KEY_MIME_TYPE = 'mime';
    const KEY_SIZE   = 'size';

    const MODE_EXACT     = 'exact';
    const MODE_CROP      = 'crop';
    const MODE_POTRAIT   = 'potrait';
    const MODE_LANDSCAPE = 'landscape';
    const MODE_AUTO      = 'auto';

    /**
     * Source file
     *
     * @var string
     */
    protected $source_file;

    /**
     * Determine image type
     *
     * @var string
     */
    protected $image_type;

    /**
     * Determine application has ready to use
     *
     * @var boolean
     */
    protected $ready = false;

    /**
     * Extension
     *
     * @var string
     */
    protected $extension;

    /**
     * Real Extension
     *
     * @var string
     */
    protected $real_extension;

    /**
     * Rsource Image created
     *
     * @var \Imagick|resource
     */
    protected $resource;

    /**
     * Original resource width
     *
     * @var integer
     */
    protected $width;

    /**
     * Original resource height
     *
     * @var integer
     */
    protected $height;

    /**
     * Resource image resized
     *
     * @var resource|\Imagick
     */
    protected $image_resized;

    /**
     * Imagick Php Extension status
     *
     * @access private
     * @var bool
     */
    private static $imagick_exist;

    /**
     * Last image size set
     *
     * @var array
     */
    protected $last_set_image = [
        self::KEY_HEIGHT => false,
        self::KEY_WIDTH => false,
        self::KEY_MODE => false
    ];

    /**
     * Allowed output result
     *
     * @var array
     */
    protected $allowed_extensions_output = ['jpg', 'jpeg', 'wbmp', 'bmp', 'gif', 'xbm', 'png'];

    /**
     * ImageResize constructor.
     */
    public function __construct()
    {
        if (!isset(self::$imagick_exist)) {
            self::$imagick_exist = class_exists('Imagick');
        }
    }

    private function determineImageFormat($extension)
    {
        if (!is_string($extension) || !trim($extension) == '') {
            return $this->extension;
        }
        $extension = explode('.', trim($extension, '.'));
        $extension = trim(strtolower(end($extension)));
        if (!$this->isUseImagick()) {
            return !in_array($extension, $this->allowed_extensions_output)
                ? $this->extension
                : $extension;
        }
        return in_array(strtoupper($extension), \Imagick::queryFormats())
            ? $extension
            : $this->extension;
    }

    /**
     * Check if use Imagick
     *
     * @return bool
     */
    public function isUseImagick()
    {
        return self::$imagick_exist;
    }

    public static function create($imageString)
    {
        if (!is_string($imageString)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid parameter image string, parameter must as a string  %s given.',
                    gettype($imageString)
                )
            );
        }
        if (!$imageString) {
            throw new \InvalidArgumentException(
                'Invalid parameter image string, parameter could not be empty.'
            );
        }
        return @file_exists($imageString)
            ? self::createFromFile($imageString)
            : self::createFromImageString($imageString);
    }

    /**
     * @param string $imageString
     * @return ImageResize
     * @throws \Exception
     */
    public static function createFromImageString($imageString)
    {
        if (!is_string($imageString)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid parameter image string, parameter must as a string  %s given.',
                    gettype($imageString)
                )
            );
        }
        $res = new self();
        $res->clear();
        if ($res->isUseImagick()) {
            $res->resource = new \Imagick();
            try {
                if (!$res->resource->readImageBlob($imageString)) {
                    throw new \RuntimeException(
                        'Invalid image string to read given.',
                        E_USER_ERROR
                    );
                }
                $res->width  = $res->resource->getImageWidth();
                $res->height = $res->resource->getImageHeight();
                $res->extension = strtolower($res->resource->getImageFormat());
                $res->ready = true;
            } catch (\Exception $e) {
                throw $e;
            }
        } else {
            $info = @getimagesizefromstring($imageString);
            if (empty($info)) {
                throw new \RuntimeException(
                    'Invalid image string to read given.',
                    E_USER_ERROR
                );
            }
            $res->width = $info[0];
            $res->height = $info[1];
            $res->image_type = $info[2];
            if (! isset($res->image_type_list[$res->image_type])) {
                $res->extension = $res->image_type_list[$res->image_type][1];
            }
            $res->resource = @imagecreatefromstring($imageString);
            $res->ready  = true;
        }

        return $res;
    }

    /**
     * Initial create
     *
     * @param string $fileName
     *
     * @return ImageResize
     * @throws \InvalidArgumentException
     */
    public static function createFromFile($fileName)
    {
        if (!is_string($fileName)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid parameter file name, parameter must be as a string %s given.',
                    gettype($fileName)
                )
            );
        }
        if (!@is_file($fileName)) {
            throw new \RuntimeException(
                sprintf(
                    sprintf('File %s does not exists!.', $fileName),
                    (strlen($fileName) > 300 ? '' : $fileName)
                )
            );
        }
        // create new current class object
        $res = new self();
        // clear
        $res->clear();
        $res->source_file = $fileName;
        $res->extension = pathinfo($res->source_file, PATHINFO_EXTENSION);
        $res->createResourceOfFile();
        return $res;
    }

    /**
     * Determine real type and set some property
     *
     * @access private
     *
     * @return void
     * @throws \Exception
     */
    private function createResourceOfFile()
    {
        $type = @exif_imagetype($this->source_file);
        if ($type === false || ! isset($this->image_type_list[$type])) {
            return;
        }

        $this->image_type = $this->image_type_list[$type][0];
        $this->real_extension = $this->image_type_list[$type][1];
        if ($this->isUseImagick() || $this->image_type_function[$this->image_type] == 'class:imagick') {
            if (!class_exists('Imagick')) {
                trigger_error(
                    'Php Imagick does not exist in server. Please check configuration',
                    E_USER_WARNING
                );
                return;
            }

            /*!
             * Set Property
             */
            $this->resource = new \Imagick($this->source_file);
            $this->width  = $this->resource->getImageWidth();
            $this->height = $this->resource->getImageHeight();
            $this->ready = true;
            return;
        }

        if (!function_exists($this->image_type_function[$this->image_type])) {
            throw new \Exception(
                sprintf(
                    'Function %s does not exist in server. Please check configuration',
                    $this->image_type_function[$this->image_type]
                ),
                E_USER_WARNING
            );
        }

        /*!
         * Set Property
         */
        $this->resource = $this->image_type_function[$this->image_type]($this->source_file);

        /**
         * if image type PNG save Alpha Blending
         */
        if ($this->image_type == 'IMAGETYPE_PNG') {
            imagealphablending($this->resource, true); // setting alpha blending on
            imagesavealpha($this->resource, true); // save alpha blending setting (important)
        }

        $this->width  = imagesx($this->resource);
        $this->height = imagesy($this->resource);
        $this->ready = true;
    }

    /**
     * Clearing default
     */
    public function clear()
    {
        $this->ready = false;
        $this->height = null;
        $this->width = null;
        $this->source_file = null;
        $this->extension = null;
        $this->real_extension = null;
        // destroy
        if (is_resource($this->image_resized)) {
            imagedestroy($this->image_resized);
        }
        $this->image_resized = null;
        if (is_resource($this->resource)) {
            imagedestroy($this->resource);
        }

        $this->resource = null;
    }

    /**
     * Check if is ready
     *
     * @return bool
     */
    public function isReady()
    {
        return $this->ready;
    }

    /*!------------------------------------------------------
                            WORKER
     ------------------------------------------------------*/

    /**
     * Set As Cropped
     *
     * @param integer $newWidth
     * @param integer $newHeight
     *
     * @return ImageResize|null
     */
    public function crop($newWidth, $newHeight)
    {
        return $this->resize($newWidth, $newHeight, self::MODE_CROP);
    }

    /**
     * Set As auto
     *
     * @param integer $newWidth
     * @param integer $newHeight
     *
     * @return ImageResize|null
     */
    public function auto($newWidth, $newHeight)
    {
        return $this->resize($newWidth, $newHeight, self::MODE_AUTO);
    }

    /**
     * Set As exactly
     *
     * @param integer $newWidth
     * @param integer $newHeight
     *
     * @return ImageResize|null
     */
    public function exact($newWidth, $newHeight)
    {
        return $this->resize($newWidth, $newHeight, self::MODE_EXACT);
    }

    /**
     * Rotate
     *
     * @param integer $degree
     *
     * @return ImageResize|null
     */
    public function rotate($degree)
    {
        if ($this->isReady()) {
            if (!is_numeric($degree)) {
                return $this;
            }
            if ($this->isUseImagick()) {
                $this->image_resized = $this->image_resized ?: clone $this->resource;
                $this->image_resized->rotateImage('transparent', $degree);
            } else {
                $this->image_resized = $this->image_resized
                    ? imagerotate($this->image_resized, $degree, 0)
                    : imagerotate($this->resource, $degree, 0);
            }

            return $this;
        }

        return null;
    }

    /**
     * Set As Potrait
     *
     * @param integer $newWidth
     * @param integer $newHeight
     *
     * @return ImageResize|null
     */
    public function potrait($newWidth, $newHeight)
    {
        return $this->resize($newWidth, $newHeight, self::MODE_POTRAIT);
    }

    /**
     * Set as Landscape
     *
     * @param integer $newWidth
     * @param integer $newHeight
     *
     * @return ImageResize|null
     */
    public function landScape($newWidth, $newHeight)
    {
        return $this->resize($newWidth, $newHeight, self::MODE_LANDSCAPE);
    }

    /**
     * Resize
     *
     * @param integer $newWidth
     * @param integer $newHeight
     * @param string  $option @uses ImageResize::MODE_CROP
     *                        @uses ImageResize::MODE_EXACT
     *                        @uses ImageResize::MODE_POTRAIT
     *                        @uses ImageResize::MODE_LANDSCAPE
     *                        @uses ImageResize::MODE_AUTO
     *                        default is @uses ImageResize::MODE_CROP
     *
     * @return ImageResize|null
     */
    public function resize($newWidth, $newHeight, $option = self::MODE_CROP)
    {
        if (!$this->isReady()) {
            return null;
        }

        $option = !is_string($option) ? self::MODE_CROP : $option;
        // Get optimal width and height - based on $option
        $optionArray = $this->getDimensions($newWidth, $newHeight, $option);
        $optimalWidth  = $optionArray[self::KEY_WIDTH];
        $optimalHeight = $optionArray[self::KEY_HEIGHT];

        $this->last_set_image = [
            self::KEY_HEIGHT => $newHeight,
            self::KEY_WIDTH  => $newWidth,
            self::KEY_MODE   => $option
        ];

        if ($this->isUseImagick()) {
            $this->image_resized = $this->image_resized ?: clone $this->resource;
            $this->image_resized->resizeImage($optimalWidth, $optimalHeight, \Imagick::FILTER_LANCZOS, 1);
            $ret_val = $this->image_resized->cropImage(
                $newWidth,
                $newHeight,
                (($optimalWidth - $newWidth) / 2),
                (($optimalHeight - $newHeight) / 2)
            );
            $this->ready = $ret_val;
            return $this;
        }

        $resource = is_resource($this->image_resized) ? $this->image_resized : $this->resource;
        $this->image_resized = imagecreatetruecolor($optimalWidth, $optimalHeight);
        // reSampling
        imagecopyresampled(
            $this->image_resized,
            $resource,
            0,
            0,
            0,
            0,
            $optimalWidth,
            $optimalHeight,
            $this->width,
            $this->height
        );

        // *** if option is 'cropProcess', then cropProcess too
        if ($option == self::MODE_CROP) {
            $this->cropProcess($optimalWidth, $optimalHeight, $newWidth, $newHeight);
        }

        return $this;
    }

    /**
     * Getting Dimension
     *
     * @param integer $newWidth
     * @param integer $newHeight
     * @param string $option
     *
     * @return array
     */
    private function getDimensions($newWidth, $newHeight, $option)
    {
        switch ($option) {
            case self::MODE_EXACT:
                $optionArray = [
                    self::KEY_HEIGHT => $newHeight,
                    self::KEY_WIDTH => $newWidth
                ];
                break;
            case self::MODE_POTRAIT:
                $optionArray = [
                    self::KEY_WIDTH =>  $this->getSizeByFixedHeight($newHeight),
                    self::KEY_HEIGHT => $newHeight
                ];
                break;
            case self::MODE_LANDSCAPE:
                $optionArray = [
                    self::KEY_WIDTH => $newWidth,
                    self::KEY_HEIGHT => $this->getSizeByFixedWidth($newWidth)
                ];
                break;
            case self::MODE_AUTO:
                $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
                break;
            default:
                $optionArray = $this->getOptimalCrop($newWidth, $newHeight);
                break;
        }

        return $optionArray;
    }

    /**
     * Get fixed size by height
     *
     * @access private
     *
     * @param integer $newHeight
     *
     * @return mixed
     */
    private function getSizeByFixedHeight($newHeight)
    {
        $ratio = $this->width / $this->height;
        $newWidth = $newHeight * $ratio;
        return $newWidth;
    }

    /**
     * Get fixed size by width
     *
     * @access private
     *
     * @param integer $newWidth
     *
     * @return mixed
     */
    private function getSizeByFixedWidth($newWidth)
    {
        $ratio = $this->height / $this->width;
        $newHeight = $newWidth * $ratio;
        return $newHeight;
    }

    /**
     * Get Auto size
     *
     * @access private
     *
     * @param integer $newWidth
     * @param integer $newHeight
     *
     * @return array
     */
    private function getSizeByAuto($newWidth, $newHeight)
    {
        // *** Image to be resized is wider (landscape)
        if ($this->height < $this->width) {
            $optimalWidth = $newWidth;
            $optimalHeight= $this->getSizeByFixedWidth($newWidth);
        } elseif ($this->height > $this->width) {
            // Image to be resized is taller (portrait)
            $optimalWidth = $this->getSizeByFixedHeight($newHeight);
            $optimalHeight= $newHeight;
        } else {
            // Image to be resized is a square
            if ($newHeight < $newWidth) {
                $optimalWidth = $newWidth;
                $optimalHeight= $this->getSizeByFixedWidth($newWidth);
            } elseif ($newHeight > $newWidth) {
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight= $newHeight;
            } else {
                // Square being resize to a square
                $optimalWidth = $newWidth;
                $optimalHeight= $newHeight;
            }
        }

        return [
            self::KEY_WIDTH => $optimalWidth,
            self::KEY_HEIGHT => $optimalHeight
        ];
    }

    /**
     * Get Optimal Crop
     *
     * @access private
     *
     * @param integer $newWidth
     * @param integer $newHeight
     *
     * @return array
     */
    private function getOptimalCrop($newWidth, $newHeight)
    {
        $heightRatio = $this->height / $newHeight;
        $widthRatio  = $this->width /  $newWidth;

        if ($heightRatio < $widthRatio) {
            $optimalRatio = $heightRatio;
        } else {
            $optimalRatio = $widthRatio;
        }

        $optimalHeight = $this->height / $optimalRatio;
        $optimalWidth  = $this->width  / $optimalRatio;

        return [
            self::KEY_WIDTH  => $optimalWidth,
            self::KEY_HEIGHT => $optimalHeight
        ];
    }

    /**
     * Proccess crop
     *
     * @access private
     *
     * @param integer $optimalWidth
     * @param integer $optimalHeight
     * @param integer $newWidth
     * @param integer $newHeight
     *
     * @return null|bool
     */
    private function cropProcess($optimalWidth, $optimalHeight, $newWidth, $newHeight)
    {
        if (!$this->isReady()) {
            return null;
        }

        // *** Find center - this will be used for the cropProcess
        $cropStartX = ($optimalWidth / 2) - ($newWidth / 2);
        $cropStartY = ($optimalHeight/ 2) - ($newHeight / 2);

        $crop = $this->image_resized;
        // Now cropProcess from center to exact requested size
        $this->image_resized = imagecreatetruecolor($newWidth, $newHeight);

        // re-sampling
        imagecopyresampled(
            $this->image_resized,
            $crop,
            0,
            0,
            $cropStartX,
            $cropStartY,
            $newWidth,
            $newHeight,
            $newWidth,
            $newHeight
        );

        return true;
    }

    /**
     * Save The image result reSized
     *
     * @param string  $savePath     Full path of file name eg [/path/of/dir/image/image.jpg]
     * @param integer $imageQuality image quality [1 - 100]
     * @param bool    $overwrite        force rewrite existing image if there was savepath exists
     *
     * @return bool|array           aboolean false if on fail otherwise array
     * @throws \Exception
     */
    public function saveTo($savePath, $imageQuality = 100, $overwrite = false)
    {
        if (!$this->isReady()) {
            return false;
        }

        // file exist
        if (file_exists($savePath)) {
            if (!$overwrite) {
                return false;
            }
            if (!is_writable($savePath)) {
                throw new \Exception(
                    'File exist! And could not to be replace',
                    E_USER_WARNING
                );
            }
        }

        $dir_name = dirname($savePath);
        if (!$dir_name || !is_dir($dir_name)) {
            throw new \Exception(
                'Directory Target Does not exist.',
                E_USER_WARNING
            );
        }
        if (!is_writable($dir_name)) {
            throw new \Exception(
                'Directory Target is not writable. Please check directory permission.',
                E_USER_WARNING
            );
        }

        return $this->generateSave($savePath, $imageQuality);
    }

    /**
     * Show Image in array path with base64
     *
     * @param int  $imageQuality
     * @param null $extension
     * @return array|bool
     */
    public function show($imageQuality = 100, $extension = null)
    {
        if (!$this->isReady()) {
            return false;
        }
        return $this->generateSave(null, $imageQuality, $extension);
    }

    /**
     * @param null|string $savePath
     * @param int         $imageQuality 1 - 100
     * @param null|string $extension
     * @return array|bool
     * @throws \Exception
     */
    private function generateSave($savePath = null, $imageQuality = 100, $extension = null)
    {
        if (!$this->isReady()) {
            return false;
        }

        $imageQuality = !is_int($imageQuality) || $imageQuality > 100
            ? 100
            : ($imageQuality < 1 ? 1 : $imageQuality);
        // check if has on cropProcess
        if (!isset($this->image_resized)) {
            if ($this->last_set_image[self::KEY_WIDTH] === false || ! $this->image_resized) {
                $this->image_resized = $this->isUseImagick()
                    ? clone $this->resource
                    : $this->resource;
            } else {
                // set from last result
                $this->resize(
                    $this->last_set_image[self::KEY_WIDTH],
                    $this->last_set_image[self::KEY_HEIGHT],
                    $this->last_set_image[self::KEY_MODE]
                );
            }
        }

        $extension = $savePath !== null
            ? pathinfo($savePath, PATHINFO_EXTENSION)
            : ($extension ?: $this->extension);
        if ($this->isUseImagick()) {
            $extension = $this->determineImageFormat($extension);
            $this->image_resized->setImageFormat($extension);
            $mime = $this->image_resized->getImageMimeType();
            $this->image_resized->setCompressionQuality($imageQuality);
            if ($savePath) {
                if (!$fp = @fopen($savePath, 'wb')) {
                    $this->image_resized->clear();
                    $this->image_resized = null;
                    throw new \Exception(
                        'Could not write into your target directory. Resource image resize cleared.',
                        E_USER_WARNING
                    );
                }
                $path = is_file($savePath) && realpath($savePath) ? realpath($savePath) : $savePath;
                $this->image_resized->getImage();
                $ret_val = $this->image_resized->writeImageFile($fp);
                if (!empty($fp)) {
                    @fclose($fp);
                }
            } else {
                $ret_val = true;
                $path = $this->image_resized->getImageBlob();
            }

            $width  = $this->image_resized->getImageWidth();
            $height = $this->image_resized->getImageHeight();
            $size = $this->image_resized->getImageLength();

            $this->image_resized->clear();
            $this->image_resized->destroy();
            $this->image_resized = null;

            return ! $ret_val ? false : [
                self::KEY_WIDTH  => $width,
                self::KEY_HEIGHT => $height,
                self::KEY_SIZE   => $size,
                self::KEY_MIME_TYPE => $mime,
                self::KEY_PATH   => $path,
            ];
        }

        $ret_val = false;

        if (!$savePath) {
            $extension = $this->determineImageFormat($extension);
        }

        // check if image output type allowed
        if (!in_array($extension, $this->allowed_extensions_output)) {
            throw new \Exception(
                'Invalid file type of target',
                E_USER_WARNING
            );
        }

        if (!$savePath) {
            ob_start();
            $savePath = null;
        }
        $mime = 'image/'.$extension;
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $mime = 'image/jpeg';
                $ret_val = imagejpeg($this->image_resized, $savePath, $imageQuality);
                break;
            case 'wbmp':
            case 'bmp':
                $mime    = 'image/bmp';
                $ret_val = imagewbmp($this->image_resized, $savePath);
                break;
            case 'gif':
                $ret_val = imagegif($this->image_resized, $savePath);
                break;
            case 'xbm':
                $ret_val = imagexbm($this->image_resized, $savePath);
                break;
            case 'png':
                $scaleQuality = round(($imageQuality/100) * 9);
                $invertScaleQuality = 9 - $scaleQuality;
                $ret_val = imagepng($this->image_resized, $savePath, $invertScaleQuality);
                break;
        }

        $width  = imagesx($this->image_resized);
        $height = imagesy($this->image_resized);
        // destroy resource to make memory freely
        @imagedestroy($this->image_resized);
        $this->image_resized = null;

        if (!$ret_val) {
            return false;
        }
        if ($savePath) {
            $path = is_file($savePath) && realpath($savePath) ? realpath($savePath) : $savePath;
            $size = filesize($path);
        } else {
            $path = ob_get_clean();
            $size = strlen($path);
        }
        return [
            self::KEY_WIDTH  => $width,
            self::KEY_HEIGHT => $height,
            self::KEY_MIME_TYPE => $mime,
            self::KEY_SIZE   => $size,
            self::KEY_PATH   => $path,
        ];
    }

    /**
     * Optimize Image Only & save into Target
     *
     * @param null|string $savePath
     * @param bool $overwrite overwrite even exists
     *
     * @return bool|array
     * @throws \Exception
     */
    public function optimizeTo($savePath = null, $overwrite = false)
    {
        if (!$this->isReady()) {
            return false;
        }

        if (! $savePath) {
            $savePath = $this->source_file;
        } elseif (file_exists($savePath)) {
            if (!$overwrite) {
                return false;
            }

            if (!is_writable($savePath)) {
                throw new \Exception(
                    'File exist! And could not to be replace',
                    E_USER_WARNING
                );
            }
        }

        $dir_name = dirname($savePath);
        if (!$dir_name || !is_dir($dir_name)) {
            throw new \Exception(
                'Directory Target Does not exist.',
                E_USER_WARNING
            );
        }

        if (!is_writable($dir_name)) {
            throw new \Exception(
                'Directory Target is not writable. Please check directory permission.',
                E_USER_WARNING
            );
        }

        return $this->generateOptimize($savePath);
    }

    /**
     * Show Image in array path with base64 optimize only
     *
     * @param null $extension
     * @return array|bool
     */
    public function optimizeShow($extension = null)
    {
        if (!$this->isReady()) {
            return false;
        }
        return $this->generateOptimize(null, $extension);
    }

    /**
     * Process Optimize
     *
     * @param null|string $savePath
     * @param null|string $extension
     * @return array|bool
     * @throws \Exception
     */
    private function generateOptimize($savePath = null, $extension = null)
    {
        if (!$this->isReady()) {
            return false;
        }

        $extension = $savePath !== null
            ? pathinfo($savePath, PATHINFO_EXTENSION)
            : ($extension ?: $this->extension);

        if ($this->isUseImagick()) {
            $extension = $this->determineImageFormat($extension);
            /**
             * @var \Imagick
             */
            $image_source = clone $this->resource;
            $image_source->setImageFormat($extension);
            $image_source->stripImage();
            // just normalize quality to 92
            $image_source->setCompressionQuality(92);
            $mime = $image_source->getImageMimeType();
            if ($savePath) {
                if (!$fp = @fopen($savePath, 'wb')) {
                    $image_source->clear();
                    $image_source->destroy();
                    $image_source = null;
                    throw new \Exception(
                        'Could not write into your target directory.',
                        E_USER_WARNING
                    );
                }
                $ret_val = $image_source->writeImageFile($fp);
                if (!empty($fp)) {
                    @fclose($fp);
                }
                $path   = is_file($savePath) && realpath($savePath) ? realpath($savePath) : $savePath;
            } else {
                $ret_val = true;
                $path = $image_source->getImageBlob();
            }

            $width   = $image_source->getImageWidth();
            $height  = $image_source->getImageHeight();
            $size    = $image_source->getImageLength();
            $image_source->clear();
            $image_source->destroy();
            $image_source = null;
            return ! $ret_val ? false : [
                self::KEY_WIDTH  => $width,
                self::KEY_HEIGHT => $height,
                self::KEY_SIZE   => $size,
                self::KEY_MIME_TYPE => $mime,
                self::KEY_PATH   => $path,
            ];
        }

        if (!$savePath) {
            $extension = $this->determineImageFormat($extension);
        }

        // check if image output type allowed
        if (!in_array($extension, $this->allowed_extensions_output)) {
            throw new \Exception(
                'Invalid file type of target',
                E_USER_WARNING
            );
        }

        $image_source = imagecreatetruecolor($this->width, $this->height);
        imagecopy($image_source, $this->resource, 0, 0, 0, 0, $this->width, $this->height);

        $ret_val = false;
        if (!$savePath) {
            ob_start();
            $savePath = null;
        }
        $mime = 'image/'.$extension;
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $mime = 'image/jpeg';
                $ret_val = imagejpeg($image_source, $savePath, 100);
                break;
            case 'wbmp':
            case 'bmp':
                $mime = 'image/bmp';
                $ret_val = imagewbmp($image_source, $savePath);
                break;
            case 'gif':
                $ret_val = imagegif($image_source, $savePath);
                break;
            case 'xbm':
                $ret_val = imagexbm($image_source, $savePath);
                break;
            case 'png':
                $ret_val = imagepng($image_source, $savePath, 9);
                break;
        }

        // destroy resource to make memory freely
        @imagedestroy($image_source);
        if (!$ret_val) {
            return false;
        }
        if ($savePath) {
            $path = is_file($savePath) && realpath($savePath) ? realpath($savePath) : $savePath;
            $size = filesize($path);
        } else {
            $path = ob_get_clean();
            $size = strlen($path);
        }

        return [
            self::KEY_WIDTH  => $this->width,
            self::KEY_HEIGHT => $this->height,
            self::KEY_SIZE   => $size,
            self::KEY_MIME_TYPE => $mime,
            self::KEY_PATH   => $path,
        ];
    }

    /*!------------------------------------------------------
                        MAGIC METHOD
     ------------------------------------------------------*/

    /**
     * Magic method destruct
     */
    public function __destruct()
    {
        $this->clear();
    }

    /**
     * @return mixed|string
     */
    public function __toString()
    {
        $res = $this->show();
        if (is_array($res)) {
            return $res[self::KEY_PATH];
        }
        return '';
    }
}
