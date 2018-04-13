<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Note;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;





class NoteType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control']]
            )
            ->add('content', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']]
            )
            ->add('category', ChoiceType::class, array(
                'label' => 'Category',
                'choices' => $options['categories'],
                'choice_label' => function($category){
                        return $category->getWording();
                    }
                )
            )
            ->add('save', SubmitType::class, [
                'label' => 'Create',
                'attr' => ['class' => 'btn btn-primary mt-3']]
            )
        ;
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        //'data_class' represents the Entity linked to the form
        $resolver->setDefaults([
            'data_class' => Note::class,
            'categories' => array(Category::class)
        ]);
    }
}
