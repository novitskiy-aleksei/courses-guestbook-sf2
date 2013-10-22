<?php

namespace Courses\GuestBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $posts = [];
        $products = $this->get('doctrine')
            ->getRepository('GuestBookBundle:Post')
            ->findAll()
        ;
        foreach ((array)Post::findAll() as $post) {
            $posts[] = [
                'post' => $post,
                'user' => User::find(['_id' => new MongoId($post['user']->__toString() ) ])
            ];
        }

        View::make('index\index', [
            'posts' => $posts,
        ]);

        return $this->render('CoursesGuestBookBundle:Default:index.html.twig', array('name' => 'aaa'));
    }

    public function post()
    {
        $title = Input::post('title');
        $text = Input::post('text');

        Post::insert([
            'title' => $title,
            'text'  => $text,
            'user'  => Session::get('user')['_id']
        ]);

        Core::redirect('/');
    }
}
