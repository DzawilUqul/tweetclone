<?php

namespace App\Models;

use App\Entities\Tweet;
use CodeIgniter\Model;

class TweetModel extends Model
{
    protected $table = 'tweets';
    protected $allowedFields = [
        'user_id', 'content', 'category'
    ];

    protected $returnType = \App\Entities\Tweet::class;
    public $rules = [
        'content' => 'required',
        'category' => 'required'
    ];

	public function newTweet($curUser, $post)
    {
        $tweet = new \App\Entities\Tweet();
        $tweet->user_id = $curUser['userid'];
        $tweet->content = $post['content'];
        $tweet->category = $post['category'];
        $this->save($tweet);
    }

    public function editTweet($post)
    {
        $tweet = $this->find($post['id']);
        if($tweet)
        {
            $tweet->content = $post['content'];
            $tweet->category = $post['category'];
            $this->save($tweet);
            return true;
        } else 
        {
            return false;
        }
    }

    public function delTweet($user_id, $tweet_id)
    {
        $tweet = $this->find($tweet_id);
        if($tweet)
        {
            if($user_id == $tweet->user_id)
            {
                $this->delete($tweet->id, true);
                return true;
            } else 
            {
                return false;
            }
        }
    }

    public function getLatest()
    {
        $query = $this->select('tweets.id, user_id, username, fullname, content, category, created_at, profile_image')
                    ->orderBy('created_at', 'desc')
                    ->join('users', 'users.id = tweets.user_id');
        return $query->findAll();
    }

    public function getByCategory($category)
    {
        $query = $this->select('tweets.id, user_id, username, fullname, content, category, created_at')
                    ->where('category', $category)->orderBy('created_at', 'desc')
                    ->join('users', 'users.id = tweets.user_id');;
        return $query->findAll();
    }
}