<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
        
        // Auto-detect and update inactive ormas status based on SK expiration date
        try {
            $db = \Config\Database::connect();
            $today = date('Y-m-d');
            $db->query("UPDATE mst_ormas SET status = 'Tidak Aktif', updated_at = NOW() WHERE tgl_sk_kedaluwarsa IS NOT NULL AND tgl_sk_kedaluwarsa < ?", [$today]);
            $db->query("UPDATE mst_ormas SET status = 'Aktif', updated_at = NOW() WHERE (tgl_sk_kedaluwarsa IS NULL OR tgl_sk_kedaluwarsa >= ?) AND status = 'Tidak Aktif'", [$today]);
        } catch (\Exception $e) {
            // Silence database exceptions during setup/migrations
        }
    }
}
