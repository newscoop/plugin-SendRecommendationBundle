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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SettingsType extends AbstractType
{   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
            ->add('toEmail', 'email', array(
                'label' => 'plugin.recommendation.label.toemail',
                'error_bubbling' => true,
                'required' => true
            ));
    }

    public function getName()
    {
        return 'omniboxRecommendationSettings';
    }
}
