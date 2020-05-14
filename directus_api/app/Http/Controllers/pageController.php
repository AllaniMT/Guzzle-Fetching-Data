<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use \GuzzleHttp\Client;
use Hamcrest\Core\HasToString;
use Illuminate\Console\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests;
use function PHPSTORM_META\type;

class pageController extends Controller
{
    protected  $suffix = '/api/items/news';
    protected $filterString = '?filter[status][eq]=published';
    protected $filterString2 = '?filter[tag][contains???]=techbar';
    protected $filterById = '?filter[id][eq]=';
    protected $filterBySlug = '?filter[slug][eq]=';

    // Parsing param to use as (Second, third...) param for Filtering
    public function filterToSecFilter($param)
    {
        return str_replace('?', '&', $param);
    }

    //manipulate the url based on Postman Headers
    public function showAllNews()
    {
            $client = new Client;
            //Take Variables from from Postman
            $variables = request()->headers;
            $arrays2 = (array) $variables;
            $baseUrl = env('APP_DIRECTUSAPI');

            foreach ($arrays2 as $array2)
            {
                if(array_key_exists('x-work-env', $array2))
                {
                    if(in_array('prod', $array2['x-work-env']))
                    {
                        $url = $baseUrl.$this->suffix.$this->filterString;
                        $cacheKey = 'prod';
                    }
                    else if(in_array('local', $array2['x-work-env']))
                    {
                        $url = $baseUrl.$this->suffix;
                        $cacheKey = 'local';
                    }
                    else
                    {
                        dd('there is something wrong with your "Headers" int the Key x-work-env');
                    }
                }
            }

            $request = Cache::remember( $cacheKey, 10, function () use ($client, $url)
            {
                return $client->get($url);
            });

            $data =  json_decode($request->getBody());

        return response()->json($data);
    }

    //Showing Data by id
    public function showNewsById($id)
    {
            $variables = request()->headers;
            $arrays2 = (array) $variables; // convert Object to array
            $baseUrl = env('APP_DIRECTUSAPI');
            $client = new Client;

            foreach ($arrays2 as $array2)
            {
                if(array_key_exists('x-work-env', $array2))
                {
                    if(in_array('prod', $array2['x-work-env']))
                    {
                        $secFilter = $this->filterToSecFilter($this->filterById);
                        $url = $baseUrl . $this->suffix . $this->filterString . $secFilter . $id;
                    }
                    else if(in_array('local', $array2['x-work-env'])) // muss gelöscht werden
                    {
                        $url = $baseUrl.$this->suffix . $this->filterById . $id;
                    }
                    else
                    {
                        dd('there is something wrong with your "Headers" int the Key x-work-env');
                    }
                }
            }

            $request = Cache::remember('news-{$id}', 10, function () use ($client, $url)
            {
                return $client->get($url);
            });

            $dataById =  json_decode($request->getBody());

        if(empty($dataById->data))
        {
            return response()->json('this Site Doesnt exist');
        }else{
            return response()->json($dataById);
        }
    }

    //Showing Data by slug
    public function showNewsBySlug($slug)
    {
            $variables = request()->headers;
            $arrays2 = (array)$variables;
            $baseUrl = env('APP_DIRECTUSAPI');
            $client = new Client;

            foreach ($arrays2 as $array2)
            {
                if(array_key_exists('x-work-env', $array2))
                {
                    if(in_array('prod', $array2['x-work-env']))
                    {
                        $secFilter = $this->filterToSecFilter($this->filterBySlug);
                        $url = $baseUrl . $this->suffix . $this->filterString . $secFilter . $slug;
                    }
                    else if(in_array('local', $array2['x-work-env']))
                    {
                        $url = $baseUrl.$this->suffix . $this->filterBySlug . $slug;
                    }
                    else
                    {
                        dd('there is something wrong with your "Headers" int the Key x-work-env ');
                    }
                }
            }

            $request = Cache::remember('new-{$slug}', 10, function () use ($client, $url)
            {
                return $client->get($url);
            });

            $dataBySlug =  json_decode($request->getBody());

        if(empty($dataBySlug->data))
        {
            return response()->json('this Site Doesnt exist');
        }else{
            return response()->json($dataBySlug);
        }

    }
}
