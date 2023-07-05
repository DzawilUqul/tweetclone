<?php

namespace App\Models;

use App\Entities\Tweet;
use CodeIgniter\Model;

class TweetModel extends Model
{
    protected $table = 'tweets';
    protected $allowedFields = [
        'user_id', 'content', 'category', 'tweet_image',
    ];

    protected $returnType = \App\Entities\Tweet::class;
    public $rules = [
        'content' => 'required',
        'category' => 'required'
    ];

    public $tweetImageRules = [
        'tweet_image' => 'uploaded[tweet_image]|max_size[tweet_image,1024]|is_image[tweet_image]|mime_in[tweet_image,image/jpg,image/jpeg,image/png]'
    ];

	public function newTweet($curUser, $post, $tweet_image)
    {
        $tweet = new \App\Entities\Tweet();
        $tweet->user_id = $curUser['userid'];
        $tweet->content = $post['content'];
        $tweet->category = $post['category'];
        $tweet->tweet_image = $tweet_image;
        $this->save($tweet);
    }

    public function editTweet($post,$tweet_image)
    {
        $tweet = $this->find($post['id']);
        if($tweet)
        {
            $tweet->content = $post['content'];
            $tweet->category = $post['category'];
            $tweet->tweet_image = $tweet_image;
            $this->update($tweet->id, [
                'content' => $tweet->content,
                'category' => $tweet->category,
                'tweet_image' => $tweet->tweet_image
            ]);
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
        $query = $this->select('tweets.id, user_id, username, fullname, content, category, created_at, profile_image, tweet_image')
                    ->orderBy('created_at', 'desc')
                    ->join('users', 'users.id = tweets.user_id');
        return $query->findAll();
    }

    public function getByCategory($category)
    {
        $query = $this->select('tweets.id, user_id, username, fullname, content, category, created_at, profile_image, tweet_image')
                    ->where('category', $category)->orderBy('created_at', 'desc')
                    ->join('users', 'users.id = tweets.user_id');;
        return $query->findAll();
    }
}