<?php

namespace App\Controller;

use App\Model\FilmManager;
use App\Model\CategoryManager;

class FilmController extends AbstractController
{
    /**
     * List films
     */
    public function index(): string
    {
        $filmManager = new FilmManager();
        $films = $filmManager->selectAll();

        return $this->twig->render('Film/index.html.twig', ['films' => $films]);
    }


    /**
     * Show informations for a specific film
     */
    public function show(int $id): string
    {
        $filmManager = new FilmManager();
        $film = $filmManager->selectOneById($id);

        return $this->twig->render('Film/show.html.twig', ['film' => $film]);
    }


    /**
     * Edit a specific film
     */
    public function edit(int $id): string
    {
        $categoryManager = new CategoryManager();
        $categorys = $categoryManager->selectAll();
        $errors = [];
        $filmManager = new FilmManager();
        $film = $filmManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $film = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $filmManager->update($film);
            header('Location: /films/show?id=' . $id);
        }

        return $this->twig->render('Film/edit.html.twig', [
            'film' => $film, 'categorys' => $categorys, 'errors' => $errors
        ]);
    }


    /**
     * Add a new film
     */
    public function add(): string
    {
        $categoryManager = new CategoryManager();
        $categorys = $categoryManager->selectAll();
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $film = array_map('trim', $_POST);

            // TODO validations (length, format...)
            if (empty($film['title'])) {
                $errors = 'Le titre du film est obligatoire';
            }
            if (empty($film['description'])) {
                $errors = 'La description du film est obligatoire';
            }
            if (empty($film['year'])) {
                $errors = "L'année du film est obligatoire";
            }
            if (empty($film['categoryId'])) {
                $errors = "La catégorie du film est obligatoire";
            }
            if (empty($errors)) {
                // if validation is ok, insert and redirection
                $filmManager = new FilmManager();
                $id = $filmManager->insert($film);
                header('Location:/films/show?id=' . $id);
            }
        }

        return $this->twig->render('Film/add.html.twig', ['categorys' => $categorys, 'errors' => $errors]);
    }


    /**
     * Delete a specific film
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $filmManager = new FilmManager();
            $filmManager->delete((int)$id);
            header('Location:/films');
        }
    }
}
