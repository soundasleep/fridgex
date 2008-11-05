<?php
// auto-generated by sfPropelCrud
// date: 2008/07/24 15:06:18
?>
<?php

/**
 * product_admin actions.
 *
 * @package    fridge
 * @subpackage product_admin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class product_adminActions extends myActions
{
	/**
	 * Only users are allowed to access pages in here.
	 * that have the appropriate permissions
	 */
	public function preExecute() {
		parent::preExecute();

		// get the user object
		$this->user = $this->getUserObject();
	}


  public function executeIndex()
  {
    return $this->forward('product', 'list');
  }

  public function executeCreate()
  {
    $this->product = new Product();

	if (!($this->user->canEditProduct($this->product)))
		$this->insufficientRights();

    $this->setTemplate('edit');
  }

  public function executeEdit()
  {
    $this->product = ProductPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->product);

	if (!($this->user->canEditProduct($this->product)))
		$this->insufficientRights();

  }

  public function executeUpdate()
  {
    if (!$this->getRequestParameter('id'))
    {
      $product = new Product();
    }
    else
    {
      $product = ProductPeer::retrieveByPk($this->getRequestParameter('id'));
      $this->forward404Unless($product);
    }

	if (!($this->user->canEditProduct($this->product)))
		$this->insufficientRights();

    $product->setId($this->getRequestParameter('id'));
    $product->setTitle($this->getRequestParameter('title'));
    $product->setPrice($this->getRequestParameter('price'));
    $product->setIsHidden($this->getRequestParameter('is_hidden', false) && true);	// make boolean
    if ($this->user->canSetInventory($product)) {
    	$product->setInventory($this->getRequestParameter('inventory'));
	}
    $product->setSortOrder($this->getRequestParameter('sort_order'));

    // handle upload
    // from http://www.symfony-project.org/cookbook/1_0/upload
    if ($this->getRequest()->getFileName("upload_image")) {
		$product->save();
		$file_type = ".jpg";		// todo
		$fileName = "product-" . $product->getId() . "-" .
				preg_replace("/-+/im", "-",
				preg_replace("/[^A-Za-z0-9\-_]/im", "",
				preg_replace('/[\s\.]+/im', '-', $this->getRequest()->getFileName("upload_mp3")))) .
				'-' . date("YmdHis") . $file_type;
		$this->getRequest()->moveFile('upload_image', sfConfig::get("sf_web_dir") . '/images/products/'.$fileName);
		$product->setImageUrl('products/'.$fileName);
	}

    $product->save();

    return $this->redirect('product/show?id='.$product->getId());
  }

  public function executeDelete()
  {
    $product = ProductPeer::retrieveByPk($this->getRequestParameter('id'));

    $this->forward404Unless($product);

	if (!($this->user->canDeleteProduct($product)))
		$this->insufficientRights();

    $product->delete();

    return $this->redirect('product/list');
  }
}
