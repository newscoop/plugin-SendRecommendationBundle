<?php
/**
 * @package Newscoop\SendRecommendationBundle
 * @author Rafał Muszyński <rafal.muszynski@sourcefabric.org>
 * @copyright 2013 Sourcefabric o.p.s.
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Newscoop\SendRecommendationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Newscoop\SendFeedbackBundle\Form\Type\SettingsType;

class AdminController extends Controller
{
    /**
    * @Route("/admin/send-recommendation")
    * @Template()
    */
    public function indexAction(Request $request)
    {   
        $preferencesService = $this->container->get('system_preferences_service');
        $translator = $this->container->get('translator');
        $form = $this->container->get('form.factory')->create(new SettingsType(), array(
            'toEmail' => $preferencesService->SendFeedbackEmail,
        ), array());
        
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $data = $form->getData();

                $preferencesService->set('SendRecommendationEmail', $data['toEmail']);
                $this->get('session')->getFlashBag()->add('success', $translator->trans('plugin.recommendation.msg.success'));

                return $this->redirect($this->generateUrl('newscoop_sendrecommendation_admin_index'));
                
            }
            
            $this->get('session')->getFlashBag()->add('error', $translator->trans('plugin.recommendation.msg.error'));

            return $this->redirect($this->generateUrl('newscoop_sendrecommendation_admin_index'));
            
        }

        return array(
            'form' => $form->createView()
        );
    }
}
