<?php

namespace App\Controllers;
use \App\Models\TweetModel;

class Tweet extends BaseController
{
    var $categories;
    var $sess;
    var $curUser;

    var $tweetMdl;
    var $profile;

    public function __construct()
    {
        $this->categories = (new \Config\AdtConfig())->getCategories();
        $this->sess = session();
        $this->curUser = $this->sess->get('currentuser');

        $this->tweetMdl = new TweetModel();
        $userMdl = new \App\Models\UserModel();
        $this->profile = $userMdl->find($this->curUser['userid']);
    }
    
    public function index()
    {       
        $data['categories'] = $this->categories;
        $data['judul'] = 'Tweet Terbaru';

        $data['profile'] = $this->profile;
        $data['tweets'] = $this->tweetMdl->getLatest();
        
        return view('tweet_home', $data);
    }
    
    public function category($category)
    {
        $data['categories'] = $this->categories;
        $data['profile'] = $this->profile;
        $data['judul'] = 'Tweet Kategori #'.$category;
        $data['tweets'] = $this->tweetMdl->getByCategory($category);

        return view('tweet_home', $data);
    }

    public function addForm()
    {
        $data['categories'] = $this->categories;
        return view('tweet_add', $data);
    }

    public function editForm($tweet_id)
    {
        $data['categories'] = $this->categories;
        return view('edit_tweet', $data);
    }

    public function addTweet()
    {
        $this->tweetMdl->newTweet($this->sess->get('currentuser'), $this->request->getPost());
        $this->sess->setFlashdata('addtweet', 'success');
        return redirect()->to('/');
    }

    public function delTweet($tweet_id)
    {
        return redirect()->to('/');
    }

    public function editTweet()
    {
        return redirect()->to('/');
    }
}