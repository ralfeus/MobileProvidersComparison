<?php
namespace My\MobileProvidersBundle\Controller;

use APY\DataGridBundle\Grid\Source\Document;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use My\MobileProvidersBundle\Document\Tariff;
use My\MobileProvidersBundle\Form\TariffType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class TariffController extends Controller {
    /**
     * @param Tariff $tariff
     * @return Form
     */
    private function createCreateForm(Tariff $tariff) {
        $form = $this->createForm(new TariffType(), $tariff, array(
            'action' => $this->generateUrl('tariff_create'),
            'method' => 'POST',
        ));
        return $form;
    }

    /**
     * Creates a form to delete a Tariff document by id.
     *
     * @param Id $id The entity id
     * @return Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tariff_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }

    /**
     * Creates a form to edit a Tariff document.
     *
     * @param Tariff $tariff The entity
     * @return Form
     */
    private function createEditForm(Tariff $tariff)
    {
        $form = $this->createForm(new TariffType(), $tariff, array(
            'action' => $this->generateUrl('tariff_update', array('id' => $tariff->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * @Route("/tariff", name="tariff")
     * @param Request $request
     * @return
     */
    public function indexAction(Request $request) {
//        /** @var DocumentManager $dm */
//        $dm = $this->get('doctrine_mongodb')->getManager();
//        $documents = $dm->getRepository('MyMobileProvidersBundle:Tariff')->findAll();
//
//        return $this->render('MyMobileProvidersBundle:Tariff:index.html.twig', array(
//            'documents' => $documents,
//        ));
        $grid = $this->get('grid');
        $grid->setSource(new Document('MyMobileProvidersBundle:Tariff'));
        return $grid->getGridResponse($request->isXmlHttpRequest()
            ? 'MyMobileProvidersBundle:Tariff:grid.html.twig' : 'MyMobileProvidersBundle:Tariff:index.html.twig');
    }

    /**
     * Creates a new Product entity.
     * @Route("/tariff/create", name="tariff_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $tariff = new Tariff();
        $form = $this->createCreateForm($tariff);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var DocumentManager $dm */
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($tariff);
            $dm->flush();
            if ($form->getClickedButton()->getName() === 'saveAndEdit') {
                return $this->redirect($this->generateUrl('tariff_edit', ['id' => $tariff->getId()]));
            } elseif ($form->getClickedButton()->getName() === 'saveAndNew') {
                return $this->redirect($this->generateUrl('tariff_new'));
            } else {
                return $this->redirect($this->generateUrl('tariff'));
            }
        }

        return $this->render('MyMobileProvidersBundle:Tariff:index.html.twig', array(
            'tariff' => $tariff,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Product entity.
     * @Route("/tariff/delete/{id}", name="tariff_delete")
     * @param Request $request
     * @param $id
     * @throws \Doctrine\ODM\MongoDB\LockException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $document = $dm->getRepository('MyMobileProvidersBundle:Tariff')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $dm->remove($document);
        $dm->flush();

        return $this->redirect($this->generateUrl('tariff'));
    }

    /**
     * Displays a form to create a new Product entity.
     * @Route("/tariff/new", name="tariff_new")
     */
    public function newAction()
    {
        $tariff = new Tariff();
        $form = $this->createCreateForm($tariff);

        return $this->render('MyMobileProvidersBundle:Tariff:edit.html.twig', array(
            'Tariff' => $tariff,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Product entity.
     * @Route("/tariff/show/{id}", name="tariff_show")
     * @param Id $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();

        $tariff = $dm->getRepository('MyMobileProvidersBundle:Tariff')->find($id);

        if (!$tariff) {
            throw $this->createNotFoundException('Unable to find Tariff document.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($tariff);

        return $this->render('MyMobileProvidersBundle:Tariff:show.html.twig', array(
            'tariff'      => $tariff,
            'delete_form' => $deleteForm->createView(),
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Product entity.
     * @Route("/tariff/edit/{id}", name="tariff_edit")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $tariff = $dm->getRepository('MyMobileProvidersBundle:Tariff')->find($id);

        if (!$tariff) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm = $this->createEditForm($tariff);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MyMobileProvidersBundle:Tariff:edit.html.twig', array(
            'tariff'      => $tariff,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Product entity.
     * @Route("/tariff/update/{id}", name="tariff_update")
     * @param Request $request
     * @param Id $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $tariff = $dm->getRepository('MyMobileProvidersBundle:Tariff')->find($id);

        if (!$tariff) {
            throw $this->createNotFoundException('Unable to find Tariff document.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($tariff);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $dm->flush();

            return $this->redirect($this->generateUrl('tariff_edit', array('id' => $id)));
        }

        return $this->render('MyMobileProvidersBundle:Tariff:edit.html.twig', array(
            'tariff'      => $tariff,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
}