@extends('layouts.app')
@section('content')
<div id="logo">
    <div class="row">
        <div class="col-lg-3">
            <a href="{{ URL('/') }}">
                <img src="{{ URL::asset('img/logo.png') }}" />
            </a>
        </div>
        <div class="col-lg-9">
            <h2>Automatically generate lyrics for songs.</h2>
        </div>
    </div>
</div>
<div id="main">
    <h3>Generate random songs easily</h3><hr/>
    <div class="row">
        <div class="col-lg-4">
            <strong>What is LyricSpark?</strong>
            <p>LyricSpark is a small website that automatically generates song lyrics for song writers. It's super helpful if you run out of ideas or are just bored and are seeking some inspiration.</p>
        </div>
        <div class="col-lg-4">
            <strong>How does it work?</strong>
            <p>We use something called a <a href="https://en.wikipedia.org/wiki/Markov_chain">Markov chain</a> to generate lyrics and use a large song database as source material for your songs. Basically, your song will be a Frankenstein monster.</p>
        </div>
        <div class="col-lg-4">
            <strong>My song doesn't make sense, I want my money back!</strong>
            <p>Well, first of all, this is all free, so you can't get money back you didn't spend. Second, it's a simple algorithm, so don't expect too much.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <h3>Generate Lyrics</h3><hr/>
            <form class="form" method="get" action="generate">
                <ol>
                    <li>
                        <strong>Select</strong> a music genre.
                        <select name="genre_id" class="form-control input-lg">
                            <option value="1">Acoustic</option>
                            <option value="2">Alternative</option>
                            <option value="3">Americana/Folk</option>
                            <option value="4">Rap</option>
                            <option value="5">R&B</option>
                            <option value="6">Rock</option>
                            <option value="7">Everything</option>
                        </select>
                    </li>
                    <li>
                        Select a <strong>structure</strong>.
                        <input name="structure" class="form-control input-lg" type="text" value="VCVCBC">
                        <p class="help-block">V = Verse, C = Chorus, B = Bridge</p>
                    </li>
                    <li>
                        Maximum <strong>seed lyrics</strong>.
                        <input name="max_songs" class="form-control input-lg" type="text" value="10">
                    </li>
                    <li>
                        <strong>Press</strong> this huge button.
                        <!-- You have to be polite to my poorly written CI backend -->
                        <button type="submit" class="btn btn-lg btn-block btn-success"><i class="fa fa-arrow-right" aria-hidden="true"></i> Make a dope song!</button>
                    </li>
                </ol>
            </form>
        </div>
        <div class="col-lg-7">
            <h3>Your Song</h3><hr/>
            <div class="lyrics">
                @if (isset($lyric))
                    <h2>{{$title}} <small>by LyricSpark</small></h2><hr/>
                    <p>{!!$lyric!!}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection