<?php

namespace AppBundle\Controller;

use AppBundle\Form\CheckAddressForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/shipping")
 */
class ShippingController extends Controller
{

    /**
     * @Route("/checkadress", name="checkadress")
     */
    public function checkadressAction(Request $request)
    {
        $form = $this->createForm(CheckAddressForm::class);
        $form->handleRequest($request);
        $message = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $usps = $this->get('app.usps_shipping_handler');
            $message = $usps->AddressVerify($data);
        }
        return $this->render('shipping/checkadress.html.twig', [
            'form' => $form->createView(),
            "messages"=>$message
        ]);
    }


}