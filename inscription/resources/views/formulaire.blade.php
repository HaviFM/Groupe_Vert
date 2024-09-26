@extends('template')
@section('content')
<h1>Créer Compte Utilisateur</h1>
<h2>Déja Enregistré ? Connexion</h2>
<form action="{{route('form.store')}}" method="post">
    @csrf
    @method('post')
    <label for="name">NOM</label>
    <input type="text" name="name" id="name" value="" placeholder="NOM">
    <label for="surname">PRENOM</label>
    <input type="text" name="surname" id="surname" value="" placeholder="PRENOM">
    <label for="email">EMAIL</label>
    <input type="text" name="email" id="email" value="" placeholder="EMAIL">
    <label for="userName">NOM D'UTILISATEUR</label>
    <input type="text" name="userName" id="userName" value="" placeholder="NOM D'UTILISATEUR">
    <label for="tel">TELEPHONE</label>
    <input type="text" name="tel" id="tel" value="" placeholder="TELEPHONE">
    <label for="password">MOT DE PASSE</label>
    <input type="password" name="password" id="password" value="" placeholder="*****">
    <button type="submit">Enregistrer</button>
</form> 