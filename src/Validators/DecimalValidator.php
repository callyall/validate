<?php
namespace Packaged\Validate\Validators;

use Generator;

class DecimalValidator extends NumberValidator
{
  protected $_decimalPlaces;

  /**
   * DecimalValidator constructor.
   *
   * @param int  $decimalPlaces
   * @param null $minValue
   * @param null $maxValue
   */
  public function __construct(
    $decimalPlaces, $minValue = null, $maxValue = null
  )
  {
    parent::__construct($minValue, $maxValue);
    $this->_decimalPlaces = $decimalPlaces;
  }

  protected function _doValidate($value): Generator
  {
    $passParent = true;
    foreach(parent::_doValidate($value) as $err)
    {
      yield $err;
      $passParent = false;
    }

    if($passParent)
    {
      $parts = explode('.', $value);
      if((count($parts) > 2)
        || ((count($parts) == 2) && (strlen($parts[1]) > $this->_decimalPlaces))
      )
      {
        yield $this->_makeError('must be a number to no more than ' . $this->_decimalPlaces . ' decimal places');
      }
    }
  }

  /**
   * @return int
   */
  public function getDecimalPlaces(): int
  {
    return $this->_decimalPlaces;
  }

}
