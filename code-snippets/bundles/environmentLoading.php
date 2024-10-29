namespace Kanzu\Mtn\Bundles;

defined('ABSPATH') || exit;

class Api
{
    private $dotenv;

    public function __construct(){
        // Load environment variables from the .env file
        $dotenv = \Dotenv\Dotenv::create(KANZU_MTN_PLUGIN_DIR);
        $dotenv->load();
    }
}
