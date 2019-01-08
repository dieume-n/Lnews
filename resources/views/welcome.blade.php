@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Articles</h2>
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">Add Article</button>
    <articles-list></articles-list>
    <new-article></new-article>
    <edit-article></edit-article>
</div>
@endsection

