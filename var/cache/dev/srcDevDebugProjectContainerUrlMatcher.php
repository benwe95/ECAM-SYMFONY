<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class srcDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($rawPathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $trimmedPathinfo = rtrim($pathinfo, '/');
        $context = $this->context;
        $request = $this->request ?: $this->createRequest($pathinfo);
        $requestMethod = $canonicalMethod = $context->getMethod();

        if ('HEAD' === $requestMethod) {
            $canonicalMethod = 'GET';
        }

        if (0 === strpos($pathinfo, '/api/categories')) {
            // api_category_list
            if ('/api/categories' === $pathinfo) {
                $ret = array (  '_controller' => 'App\\Controller\\CategoryApiController::listCategories',  '_route' => 'api_category_list',);
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_api_category_list;
                }

                return $ret;
            }
            not_api_category_list:

            // api_category_show
            if (preg_match('#^/api/categories/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'api_category_show')), array (  '_controller' => 'App\\Controller\\CategoryApiController::showCategory',));
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_api_category_show;
                }

                return $ret;
            }
            not_api_category_show:

            // api_category_add
            if ('/api/categories' === $pathinfo) {
                $ret = array (  '_controller' => 'App\\Controller\\CategoryApiController::addCategory',  '_route' => 'api_category_add',);
                if (!in_array($requestMethod, array('POST'))) {
                    $allow = array_merge($allow, array('POST'));
                    goto not_api_category_add;
                }

                return $ret;
            }
            not_api_category_add:

            // api_category_edit
            if (preg_match('#^/api/categories/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'api_category_edit')), array (  '_controller' => 'App\\Controller\\CategoryApiController::editCategory',));
                if (!in_array($requestMethod, array('PUT'))) {
                    $allow = array_merge($allow, array('PUT'));
                    goto not_api_category_edit;
                }

                return $ret;
            }
            not_api_category_edit:

            // api_category_del
            if (preg_match('#^/api/categories/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'api_category_del')), array (  '_controller' => 'App\\Controller\\CategoryApiController::deleteCategory',));
                if (!in_array($requestMethod, array('DELETE'))) {
                    $allow = array_merge($allow, array('DELETE'));
                    goto not_api_category_del;
                }

                return $ret;
            }
            not_api_category_del:

        }

        elseif (0 === strpos($pathinfo, '/api/notes')) {
            // api_note_list
            if ('/api/notes' === $pathinfo) {
                $ret = array (  '_controller' => 'App\\Controller\\NoteApiController::listNotes',  '_route' => 'api_note_list',);
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_api_note_list;
                }

                return $ret;
            }
            not_api_note_list:

            // api_note_show
            if (preg_match('#^/api/notes/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'api_note_show')), array (  '_controller' => 'App\\Controller\\NoteApiController::showNote',));
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_api_note_show;
                }

                return $ret;
            }
            not_api_note_show:

            // api_note_add
            if ('/api/notes' === $pathinfo) {
                $ret = array (  '_controller' => 'App\\Controller\\NoteApiController::addNote',  '_route' => 'api_note_add',);
                if (!in_array($requestMethod, array('POST'))) {
                    $allow = array_merge($allow, array('POST'));
                    goto not_api_note_add;
                }

                return $ret;
            }
            not_api_note_add:

            // api_note_edit
            if (preg_match('#^/api/notes/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'api_note_edit')), array (  '_controller' => 'App\\Controller\\NoteApiController::editNote',));
                if (!in_array($requestMethod, array('PUT'))) {
                    $allow = array_merge($allow, array('PUT'));
                    goto not_api_note_edit;
                }

                return $ret;
            }
            not_api_note_edit:

            // api_note_del
            if (preg_match('#^/api/notes/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'api_note_del')), array (  '_controller' => 'App\\Controller\\NoteApiController::deleteNote',));
                if (!in_array($requestMethod, array('DELETE'))) {
                    $allow = array_merge($allow, array('DELETE'));
                    goto not_api_note_del;
                }

                return $ret;
            }
            not_api_note_del:

        }

        elseif (0 === strpos($pathinfo, '/categories')) {
            // category_list
            if ('/categories' === $pathinfo) {
                return array (  '_controller' => 'App\\Controller\\CategoryController::showCategories',  '_route' => 'category_list',);
            }

            // category_add
            if ('/categories/add' === $pathinfo) {
                return array (  '_controller' => 'App\\Controller\\CategoryController::addCategory',  '_route' => 'category_add',);
            }

            // category_edit
            if (0 === strpos($pathinfo, '/categories/edit') && preg_match('#^/categories/edit/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_edit')), array (  '_controller' => 'App\\Controller\\CategoryController::editCategory',));
            }

            // category_del
            if (0 === strpos($pathinfo, '/categories/del') && preg_match('#^/categories/del/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_del')), array (  '_controller' => 'App\\Controller\\CategoryController::deleteCategory',));
            }

        }

        // app_homepage
        if ('' === $trimmedPathinfo) {
            $ret = array (  '_controller' => 'App\\Controller\\MainController::homepage',  '_route' => 'app_homepage',);
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_app_homepage;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'app_homepage'));
            }

            if (!in_array($canonicalMethod, array('GET'))) {
                $allow = array_merge($allow, array('GET'));
                goto not_app_homepage;
            }

            return $ret;
        }
        not_app_homepage:

        if (0 === strpos($pathinfo, '/notes')) {
            // note_list
            if ('/notes' === $pathinfo) {
                return array (  '_controller' => 'App\\Controller\\NoteController::listNotes',  '_route' => 'note_list',);
            }

            // note_add
            if ('/notes/add' === $pathinfo) {
                $ret = array (  '_controller' => 'App\\Controller\\NoteController::addNote',  '_route' => 'note_add',);
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_note_add;
                }

                return $ret;
            }
            not_note_add:

            // note_show
            if (0 === strpos($pathinfo, '/notes/show') && preg_match('#^/notes/show/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'note_show')), array (  '_controller' => 'App\\Controller\\NoteController::showNote',));
            }

            // note_search
            if ('/notes/search' === $pathinfo) {
                $ret = array (  '_controller' => 'App\\Controller\\NoteController::searchNotes',  '_route' => 'note_search',);
                if (!in_array($requestMethod, array('POST'))) {
                    $allow = array_merge($allow, array('POST'));
                    goto not_note_search;
                }

                return $ret;
            }
            not_note_search:

            // note_edit
            if (0 === strpos($pathinfo, '/notes/edit') && preg_match('#^/notes/edit/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'note_edit')), array (  '_controller' => 'App\\Controller\\NoteController::editNote',));
            }

            // note_del
            if (0 === strpos($pathinfo, '/notes/del') && preg_match('#^/notes/del/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'note_del')), array (  '_controller' => 'App\\Controller\\NoteController::deleteNote',));
            }

        }

        elseif (0 === strpos($pathinfo, '/_')) {
            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if ('/_profiler' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not__profiler_home;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', '_profiler_home'));
                    }

                    return $ret;
                }
                not__profiler_home:

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ('/_profiler/search' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ('/_profiler/search_bar' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_phpinfo
                if ('/_profiler/phpinfo' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler_open_file
                if ('/_profiler/open' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:openAction',  '_route' => '_profiler_open_file',);
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

        }

        if ('/' === $pathinfo && !$allow) {
            throw new Symfony\Component\Routing\Exception\NoConfigurationException();
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
