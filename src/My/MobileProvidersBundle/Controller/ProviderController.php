<?php
namespace My\MobileProvidersBundle\Controller;

use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Source\Document;
use APY\DataGridBundle\Grid\Source\Vector;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use My\MobileProvidersBundle\Document\Provider;
use My\MobileProvidersBundle\Form\ProviderType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProviderController extends Controller {
    /**
     * @param Provider $provider
     * @return \Symfony\Component\Form\Form
     */
    private function createCreateForm(Provider $provider) {
        $form = $this->createForm(new ProviderType(), $provider, array(
            'action' => $this->generateUrl('provider_create'),
            'method' => 'POST',
        ));
        return $form;
    }

    /**
     * Creates a form to delete a Product entity by id.
     *
     * @param Id $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('provider_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }

    /**
     * Creates a form to edit a Product entity.
     *
     * @param Provider $provider The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Provider $provider)
    {
        $form = $this->createForm(new ProviderType(), $provider, array(
            'action' => $this->generateUrl('provider_update', array('id' => $provider->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * @Route("/provider", name="provider")
     * @Template("MyMobileProvidersBundle:Provider:index.html.twig")
     */
    public function indexAction() {
//        /** @var DocumentManager $dm */
//        $dm = $this->get('doctrine_mongodb')->getManager();
//        /** @var Provider[] $documents */
//        $documents = $dm->getRepository('MyMobileProvidersBundle:Provider')->findAll();
//        $columns = [
//            new TextColumn(['id' => 'name', 'field' => 'name', 'source' => true, 'primary' => true, 'title' => 'Name']),
//            new TextColumn(['id' => 'hardwareProvider', 'field' => 'hardwareProvider', 'source' => true, 'primary' => true, 'title' => 'Hardware Provider']),
//        ];
        $grid = $this->get('grid');
//        $grid->setSource(new Vector($documents));
//        $grid->setSource(new Vector(array_map(function($provider) {
        $grid->setSource(new Document('MyMobileProvidersBundle:Provider'));
//            return ['name' => $provider->getName(), 'hardwareProvider' => $provider->getHardwareProvider()];
//        }, $documents), $columns));
        return $grid->getGridResponse();
    }

    /**
     * Creates a new Product entity.
     * @Route("/provider/create", name="provider_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $provider = new Provider();
        $form = $this->createCreateForm($provider);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var DocumentManager $dm */
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($provider);
            $dm->flush();

            if ($form->getClickedButton()->getName() === 'saveAndEdit') {
                return $this->redirect($this->generateUrl('provider_edit', ['id' => $provider->getId()]));
            } elseif ($form->getClickedButton()->getName() === 'saveAndNew') {
                return $this->redirect($this->generateUrl('provider_new'));
            } else {
                return $this->redirect($this->generateUrl('provider'));
            }
        }

        return $this->render('MyMobileProvidersBundle:Provider:index.html.twig', array(
            'provider' => $provider,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Product entity.
     * @Route("/provider/delete/{id}", name="provider_delete")
     * @param $id
     * @throws \Doctrine\ODM\MongoDB\LockException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $document = $dm->getRepository('MyMobileProvidersBundle:Provider')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $dm->remove($document);
        $dm->flush();

        return $this->redirect($this->generateUrl('provider'));
    }

    /**
     * Displays a form to create a new Product entity.
     * @Route("/provider/new", name="provider_new")
     */
    public function newAction()
    {
        $provider = new Provider();
        $form = $this->createForm(new ProviderType(), $provider, array(
            'action' => $this->generateUrl('provider_create'),
            'method' => 'POST',
        ));

        return $this->render('MyMobileProvidersBundle:Provider:edit.html.twig', array(
            'provider' => $provider,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Product entity.
     * @Route("/provider/show/{id}", name="provider_show")
     * @param Id $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();

        $provider = $dm->getRepository('MyMobileProvidersBundle:Provider')->find($id);

        if (!$provider) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MyMobileProvidersBundle:Provider:show.html.twig', array(
            'provider'      => $provider,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Product entity.
     * @Route("/provider/edit/{id}", name="provider_edit")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $provider = $dm->getRepository('MyMobileProvidersBundle:Provider')->find($id);

        if (!$provider) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm = $this->createEditForm($provider);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MyMobileProvidersBundle:Provider:edit.html.twig', array(
            'provider'      => $provider,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Product entity.
     * @Route("/update/{id}", name="provider_update")
     * @param Request $request
     * @param Id $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $provider = $dm->getRepository('MyMobileProvidersBundle:Provider')->find($id);

        if (!$provider) {
            throw $this->createNotFoundException('Unable to find Provider document.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($provider);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $dm->flush();

            return $this->redirect($this->generateUrl('provider_edit', array('id' => $id)));
        }

        return $this->render('MyMobileProvidersBundle:Provider:edit.html.twig', array(
            'provider'      => $provider,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
}