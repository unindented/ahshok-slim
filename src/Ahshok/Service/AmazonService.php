<?php

namespace Ahshok\Service;

use ZendService\Amazon\Amazon;

class AmazonService {

  private static $lookupGroups = array(
    'Small',
    'Images'
  );

  private static $lookupMap = array(
    'asin'         => 'ASIN',
    'title'        => 'Title',
    'author'       => 'Author',
    'link'         => 'DetailPageURL',
    'small_image'  => 'SmallImage->Url',
    'medium_image' => 'MediumImage->Url',
    'large_image'  => 'LargeImage->Url'
  );

  private $config;
  private $amazon;

  public function __construct(array $config, Amazon $amazon) {
    $this->config = $config;
    $this->amazon = $amazon;
  }

  public function lookup($asin) {
    $item = $this->amazon->itemLookup($asin, array(
      'AssociateTag'  => $this->config['tag'],
      'ResponseGroup' => implode(',', self::$lookupGroups)
    ));

    $extract = function ($value) use ($item) {
      $value = array_reduce(explode('->', $value), function ($memo, $method) {
        return (is_object($memo) && property_exists($memo, $method)) ? $memo->$method : null;
      }, $item);

      if (is_array($value)) {
        $value = implode(', ', $value);
      }

      return (string)$value;
    };

    return array_map($extract, self::$lookupMap);
  }

}
