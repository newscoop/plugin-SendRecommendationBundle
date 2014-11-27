<?php
/**
 * @package Newscoop\SendRecommendationBundle
 * @author Mischa Gorinskat <mischa.gorinskat@sourcefabric.org>
 * @copyright 2014 Sourcefabric o.p.s.
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Newscoop\SendRecommendationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SendRecommendationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('person_name', null, array(
                'label' => 'plugin.feedback.form.recommendation.label.person_name',
                'error_bubbling' => true,
                'required' => true
            ))
            ->add('person_job', null, array(
                'label' => 'plugin.feedback.form.recommendation.label.person_job',
                'error_bubbling' => true,
                'required' => true
            ))
            ->add('person_phone', null, array(
                'label' => 'plugin.feedback.form.recommendation.label.person_phone',
                'error_bubbling' => true,
                'required' => true
            ))
            ->add('person_email', null, array(
                'label' => 'plugin.feedback.form.recommendation.label.persone_mail',
                'error_bubbling' => true,
                'required' => true
            ))
            ->add('person_recommendation', null, array(
                'label' => 'plugin.feedback.form.recommendation.label.person_recommendation',
                'error_bubbling' => true,
                'required' => true
            ))
            ->add('recommendee_name', null, array(
                'label' => 'plugin.feedback.form.recommendation.label.recommendee_name',
                'error_bubbling' => true,
                'required' => true
            ))
            ->add('recommendee_job', null, array(
                'label' => 'plugin.feedback.form.recommendation.label.recommendee_job',
                'error_bubbling' => true,
                'required' => true
            ))
            ->add('recommendee_phone', null, array(
                'label' => 'plugin.feedback.form.recommendation.label.recommendee_phone',
                'error_bubbling' => true,
                'required' => true
            ))
            ->add('recommendee_email', null, array(
                'label' => 'plugin.feedback.form.recommendation.label.recommendee_email',
                'error_bubbling' => true,
                'required' => true
            ))
            ->add('recommendee_expertise', null, array(
                'label' => 'plugin.feedback.form.recommendation.label.recommendee_expertise',
                'error_bubbling' => true,
                'required' => true
            ))
            ->add('recommendee_achievements', null, array(
                'label' => 'plugin.feedback.form.recommendation.label.recommendee_achievements',
                'error_bubbling' => true,
                'required' => false
            ))
            ->add('recommendee_notes', null, array(
                'label' => 'plugin.feedback.form.recommendation.label.recommendee_notes',
                'error_bubbling' => true,
                'required' => false
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return 'sendRecommendationForm';
    }
}
