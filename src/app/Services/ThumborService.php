<?php

namespace App\Services;

use Thumbor\Url\BuilderFactory;

class ThumborService
{

    private $thumbor;

    public function __construct(FileService $file, BuilderFactory $thumbor)
    {
        $this->thumbor = $thumbor;
    }

    /*
    trim($colourSource = null)
 * @method Builder crop($topLeftX, $topLeftY, $bottomRightX, $bottomRightY)
 * @method Builder fitIn($width, $height)
 * @method Builder resize($width, $height)
 * @method Builder halign($halign)
 * @method Builder valign($valign)
 * @method Builder smartCrop($smartCrop)
 * @method Builder addFilter($filter, $args, $_ = null)
 * @method Builder metadataOnly($metadataOnly)
 */

    //renvoi le lien vers thumbor de l'image
    public function getImgLink($file,$resolution="0x0"){
        $file = str_replace('/mydata/','',$file);
        //return "/convert/unsafe/".$resolution.'/'.$file;
        $file = str_replace(' ','%20',$file);//
        $file = urlencode($file);

        $dimension = explode('x',$resolution);

        return $this->thumbor->url($file)
        ->resize($dimension[0],$dimension[1]);
        //->addFilter('fill', 'green');
    }

}
