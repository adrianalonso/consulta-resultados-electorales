<?php

namespace App\Controller;

use App\Transformer\DatTransformer;
use League\Csv\Writer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TransformerController
 * @package App\Controller
 */
class TransformerController extends Controller
{
    /**
     * @var DatTransformer
     */
    private $transformer;

    /**
     * TransformerController constructor.
     */
    public function __construct(DatTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @Route("/", name="home")
     * @Method("GET")
     */
    public function home()
    {
        $form = $this->createFileForm();

        return $this->render('home.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/", name="transformer")
     * @Method("POST")
     */
    public function submit(Request $request)
    {
        $form = $this->createFileForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $file = $form->get('file')->getData();

            $result = $this->transformer->transform($file);

            $originalName = str_replace('.', '', $file->getClientOriginalName());
            $filePath = "/tmp/" . $originalName . "_" . uniqid() . ".csv";

            $writer = Writer::createFromPath($filePath, 'w+');
            $writer->setDelimiter(";");
            $writer->insertAll($result);

            return $this->file($filePath);
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createFileForm()
    {
        return $this->createFormBuilder()->add('file', FileType::class)->getForm();
    }
}
