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
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/recommendation/send")
     * @Route("/{lang}/recommendation/send")
     */
    public function showAction(Request $request, $lang = 'ar')
    {
        $templatesService = $this->container->get('newscoop.templates.service');
        $smarty = $templatesService->getSmarty();
        $gimme =  $smarty->context();
        $gimme->language = \MetaLanguage::createFromCode($lang);
        $smarty->assign('gimme', $gimme);
        $request->setLocale($lang);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');
        $response->setContent($templatesService->fetchTemplate('_view/form-recommendation.tpl'));

        return $response;
    }

    /**
     * @Route("/recommendation/post")
     * @Route("/{lang}/recommendation/post")
     * @Method("POST")
     */
    public function postAction(Request $request, $lang = 'ar')
    {
        $translator = $this->container->get('translator');
        $preferencesService = $this->container->get('system_preferences_service');
        $to = $preferencesService->SendRecommendationEmail;
        $defaultFrom = $preferencesService->EmailFromAddress;
        $response = array();
        $parameters = $request->request->all();
        $request->setLocale($lang);

        $form = $this->container->get('form.factory')->create(new SendRecommendationType(), array(), array());

        if ($request->isMethod('POST')) {

            $form->bind($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $date = new \DateTime("now");

                $subject = $translator->trans('plugin.recommendation.email.subject', array('%name%' => $data['person_name']), 'messages');

                $body = '';
                foreach ($data AS $name => $value) {

                    if ($name == 'person_name') {
                        $body .= '<b>'.$translator->trans('plugin.recommendation.form.label.person_group_label').'</b><br>';
                    } elseif ($name == 'recommendee_name') {
                        $body .= '<br><b>'.$translator->trans('plugin.recommendation.form.label.recommendee_group_label').'</b><br>';
                    }

                    $body .= $translator->trans('plugin.recommendation.form.label.'.$name).': '.$value .'<br>';
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
                    'message' => $translator->trans('plugin.recommendation.msg.invalid')
                );
            }

            return new JsonResponse($response);
        }
    }
}
