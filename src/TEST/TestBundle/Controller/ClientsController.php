<?php

namespace TEST\TestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use TEST\TestBundleBundle\Entity\Clients;
use TEST\TestBundleBundle\Form\ClientsType;

/**
 * Clients controller.
 *
 */
class ClientsController extends Controller
{

    /**
     * Lists all Clients entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TestBundle:Clients')->findAll();

        return $this->render('TestBundle:Clients:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Clients entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Clients();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('clients_show', array('id' => $entity->getId())));
        }

        return $this->render('TEST\TestBundle:Clients:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Clients entity.
    *
    * @param Clients $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Clients $entity)
    {
        $form = $this->createForm(new ClientsType(), $entity, array(
            'action' => $this->generateUrl('clients_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Clients entity.
     *
     */
    public function newAction()
    {
        $entity = new Clients();
        $form   = $this->createCreateForm($entity);

        return $this->render('TestBundle:Clients:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Clients entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TestBundle:Clients')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Clients entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TestBundle:Clients:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }
    
    /**
     * Finds and displays clients in a select dropdown
     *
     */
    public function selectAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TestBundle:Clients')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Clients entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        
        $dropDownList = new \Kendo\UI\DropDownList($entity);
        $dropDownList->autoBind(true);

        return $this->render('TestBundle:Clients:select.html.twig', [
            'entity' => $entity,
            '$clients_dropdown' => $dropDownList
        ]);
    }

    /**
     * Displays a form to edit an existing Clients entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TestBundle:Clients')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Clients entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TestBundle:Clients:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Clients entity.
    *
    * @param Clients $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Clients $entity)
    {
        $form = $this->createForm(new ClientsType(), $entity, array(
            'action' => $this->generateUrl('clients_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Clients entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TestBundle:Clients')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Clients entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('clients_edit', array('id' => $id)));
        }

        return $this->render('TestBundle:Clients:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Clients entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TestBundle:Clients')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Clients entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('clients'));
    }

    /**
     * Creates a form to delete a Clients entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('clients_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
