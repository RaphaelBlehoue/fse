<?php

namespace App\Controller;

use App\Entity\Section;
use App\Form\SectionType;
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/forum/section")
 */
class SectionController extends AbstractController
{
    /**
     * @Route("/", name="section_index", methods="GET")
     * @param SectionRepository $sectionRepository
     * @return Response
     */
    public function index(SectionRepository $sectionRepository): Response
    {
        return $this->render('admin/forum/section/index.html.twig',
            ['sections' => $sectionRepository->findAll()]
        );
    }

    /**
     * @Route("/new", name="section_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $section = new Section();
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($section);
            $em->flush();

            return $this->redirectToRoute('section_index');
        }

        return $this->render('admin/forum/section/new.html.twig', [
            'section' => $section,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="section_show", methods="GET")
     * @param Section $section
     * @return Response
     */
    public function show(Section $section): Response
    {
        return $this->render('admin/forum/section/show.html.twig', ['section' => $section]);
    }

    /**
     * @Route("/{id}/edit", name="section_edit", methods="GET|POST")
     * @param Request $request
     * @param Section $section
     * @return Response
     */
    public function edit(Request $request, Section $section): Response
    {
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('section_index');
        }
        return $this->render('admin/forum/section/edit.html.twig', [
            'section' => $section,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="section_delete", methods="DELETE")
     * @param Request $request
     * @param Section $section
     * @return Response
     */
    public function delete(Request $request, Section $section): Response
    {
        if ($this->isCsrfTokenValid('delete'.$section->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($section);
            $em->flush();
        }

        return $this->redirectToRoute('section_index');
    }
}
