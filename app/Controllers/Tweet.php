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
        $data['validation'] = null;
        return view('tweet_add', $data);
    }

    public function editForm($tweet_id)
    {
        $tweet = $this->tweetMdl->find($tweet_id);
        if($tweet->user_id != $this->sess->get('currentuser')['userid'])
        {
            $this->sess->setFlashdata('edittweet', 'error');
            return redirect()->to('/');
        }
        
        $data['categories'] = $this->categories;
        $data['tweet'] = $tweet;
        $data['image'] = $tweet->tweet_image;
        return view('edit_tweet', $data);
    }

    public function addTweet()
    {
        $tweet_image = $this->request->getFile('tweet_image');
        if($tweet_image != "")
        {
            // Convert image into base64
            $path = $tweet_image->getTempName();
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $content = file_get_contents($path);
            $image = 'data:image/' . $type . ';base64,' . base64_encode($content);
            
            if($this->validate($this->tweetMdl->tweetImageRules))
            {
                $this->tweetMdl->newTweet($this->sess->get('currentuser'), $this->request->getPost(),$image);
                $this->sess->setFlashdata('addtweet', 'success');
                return redirect()->to('/');
            }
            else 
            {
                $data['validation'] = $this->validator;
                $data['categories'] = $this->categories;
                return view('tweet_add', $data);
            }
        }
        else
        {
            $image = null;
            $this->tweetMdl->newTweet($this->sess->get('currentuser'), $this->request->getPost(),$image);
            $this->sess->setFlashdata('addtweet', 'success');
            return redirect()->to('/');
        }
        
    }

    public function delTweet($tweet_id)
    {
        $result = $this->tweetMdl->delTweet($this->sess->get('currentuser')['userid'], $tweet_id);
        if($result)
        {
            $this->sess->setFlashdata('deltweet', 'success');
        } else 
        {
            $this->sess->setFlashdata('deltweet', 'error');
        }
        return redirect()->to('/');
    }

    public function editTweet()
    {
        $tweet_image = $this->request->getFile('tweet_image');
        if($tweet_image != "")
        {
            // Convert image into base64
            $path = $tweet_image->getTempName();
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $content = file_get_contents($path);
            $image = 'data:image/' . $type . ';base64,' . base64_encode($content);
            
            if($this->validate($this->tweetMdl->tweetImageRules))
            {
                $result = $this->tweetMdl->editTweet($this->request->getPost(),$image);
                if($result){
                    $this->sess->setFlashdata('edittweet', 'success');
                } else {
                    $this->sess->setFlashdata('edittweet', 'error');
                }

                return redirect()->to('/');
            }
            else 
            {
                $data['validation'] = $this->validator;
                $data['categories'] = $this->categories;
                return view('edit_tweet', $data);
            }
        }
        else
        {
            $image = null;
            $result = $this->tweetMdl->editTweet($this->request->getPost(),$image);
                if($result){
                    $this->sess->setFlashdata('edittweet', 'success');
                } else {
                    $this->sess->setFlashdata('edittweet', 'error');
                }

                return redirect()->to('/');
        }
    }
}