<?php
use Timber\Timber;

$context = Timber::context();
/* $context['menu'] = Timber::get_menu('Primary'); */

Timber::render('index.twig', $context);
