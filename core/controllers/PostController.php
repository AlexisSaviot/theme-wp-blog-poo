<?php
if (!defined('ABSPATH')) exit;

class PostController extends Controller
{
    public function __construct()
    {
        parent::__construct('post', 'PostModel');
    }

    public function getPosts()
    {
        return $this->all(['posts_per_page' => get_option( 'posts_per_page' )], true);
    }
}
