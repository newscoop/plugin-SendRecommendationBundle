<?php
/**
 * @package Newscoop\SendRecommendationBundle
 * @author Mischa Gorinskat <mischa.gorinskat@sourcefabric.org>
 * @copyright 2014 Sourcefabric o.p.s.
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Newscoop\SendRecommendationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Newscoop\SendRecommendationBundle\Form\Type\SendRecommendationType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Newscoop\EventDispatcher\Events\GenericEvent;

/**
 * Send recommendation controller
 */
class SendRecommendationController extends Controller
{
    /**
     * @Route("/plugin/send-recommendation")
     * @Method("POST")
     */
    public function indexAction(Request $request)
    {
        $translator = $this->container->get('translator');
        $em = $this->container->get('em');
        $preferencesService = $this->container->get('system_preferences_service');
        $to = $preferencesService->SendFeedbackEmail;
        $defaultFrom = $preferencesService->EmailFromAddress;
        $response = array();
        $parameters = $request->request->all();

        $form = $this->container->get('form.factory')->create(new SendRecommendationType(), array(), array());

        if ($request->isMethod('POST')) {

            $form->bind($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $date = new \DateTime("now");

                $subject = $translator->trans('Tralalal');

                $body = '';
                foreach ($data AS $name => $value) {
                    
                    $body .= $translator->trans('plugin.recommendation.form.recommendation.label.'.$name).': '.$value .'<br>';
                }

                $emailService = $this->container->get('email');
                $emailService->send($subject, $body, $to, $defaultFrom);

                $response['response'] = array(
                    'status' => true,
                    'message' => $translator->trans('plugin.recommendation.msg.success')
                );

            } else {

                $response['response'] = array(
                    'status' => false,
                    'message' => 'Invalid Form'
                );
            }

            return new JsonResponse($response);
        }
    }
}
