<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Podcast;
use App\Episode;
use SimpleXMLElement;
use Carbon\Carbon;

class FeedController extends Controller
{
    public function getFeed($podcastSlug)
    {
        $podcast=Podcast::where('slug',$podcastSlug)->firstOrFail();
        $episodes=Episode::where('podcast_id',$podcast->id)->orderBy('created_at','desc')->get();

        $itunes="http://www.itunes.com/dtds/podcast-1.0.dtd";
        $content="http://purl.org/dc/elements/1.1/";

        $xml = new SimpleXMLElement('<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"/>');
        $xml->addAttribute('version', '2.0');

        $channel=$xml->addChild('channel');

        $channel->addChild('title',$podcast->name);
        $channel->addChild('link',$podcast->website);
        $channel->addChild('description','<!CDATA['.$podcast->description.']]>');
        $channel->addChild('language',$podcast->language);
        $channel->addChild('copyright',Carbon::now()->year);
        $channel->addChild('itunes:author',$podcast->authorName,$itunes);
        $channel->addChild('itunes:subtitle',$podcast->subtitle,$itunes);
        $channel->addChild('itunes:summary',$podcast->description,$itunes);
        $channel->addChild('itunes:explicit','no',$itunes);
        $channel->addChild('lastBuildDate',Carbon::now()->toRfc2822String());

        //If there is no episode of podcast, use podcast creating date as pubDate
        $pubDate=isset($episodes)?$podcast->created_at->toRfc2822String():$episodes->first()->created_at->toRfc2822String();

        $channel->addChild('pubDate',$pubDate);

        $owner=$channel->addChild('itunes:owner',null,$itunes);
        $owner->addChild('itunes:email',$podcast->itunesEmail);
        $owner->addChild('itunes:name',$podcast->name);

        $category=$channel->addChild('itunes:category',null,$itunes);
        $category->addAttribute('text',\htmlentities($podcast->category));

        $image=$channel->addChild('itunes:image',null,$itunes);
        $image->addAttribute('href',$podcast->getArtworkImagePath());

        if(isset($episodes))
        {
            foreach ($episodes as $episode)
            {
                $item=$channel->addChild('item');
                $item->addChild('title',$episode->title);
                $item->addChild('pubDate',$episode->created_at->toRfc2822String());
                $item->addChild('link',$podcast->website);
                $item->addChild('description',strip_tags($episode->description));
                $item->addChild('itunes:duration',$episode->duration,$itunes);
                $item->addChild('itunes:author',$podcast->author,$itunes);
                $explicit=$episode->explicit?'yes':'no';
                $item->addChild('itunes:explicit',$explicit,$itunes);
                $itunesSummary='';

                if(empty($episode->itunesSummary))
                {
                    if (strlen(strip_tags($episode->description)) > 255)
                    {
                        $itunesSummary=substr(strip_tags($episode->itunesSummary),0,252).'...';
                    }
                    else
                    {
                        $itunesSummary=strip_tags($episode->description);
                    }
                }
                else
                {
                    $itunesSummary=$episode->itunesSummary;
                }
                $item->addChild('itunes:summary',$itunesSummary,$itunes);

                $subtitle="";

                if (!empty($episode->subtitle))
                {
                    $subtitle=$episode->subtitle;
                }
                else
                {
                    $subtitle=$podcast->subtitle;
                }
                
                $item->addChild('itunes:subtitle',$subtitle,$itunes);
                $episodeImage=$item->addChild('itunes:image',null,$itunes);
                $episodeImage->addAttribute('href',$episode->getImagePath());
                $enclosure=$item->addChild('enclosure');
                $enclosure->addAttribute('type','audio/mpeg');
                $enclosure->addAttribute('url',$episode->getAudioFilePath());
                $enclosure->addAttribute('length',$episode->length);
                $image=$item->addChild('image');
                $image->addAttribute('href',$episode->getImagePath());
            }
        }

        return response($xml->asXML())->header('Content-Type', 'text/xml');
    }
}
