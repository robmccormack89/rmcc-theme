<?php











namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => 'dev-master',
    'version' => 'dev-master',
    'aliases' => 
    array (
    ),
    'reference' => '449b3f6f5cb223b018981f7a4c36f84dec4c1301',
    'name' => '__root__',
  ),
  'versions' => 
  array (
    '__root__' => 
    array (
      'pretty_version' => 'dev-master',
      'version' => 'dev-master',
      'aliases' => 
      array (
      ),
      'reference' => '449b3f6f5cb223b018981f7a4c36f84dec4c1301',
    ),
    'psr/cache' => 
    array (
      'pretty_version' => '3.0.0',
      'version' => '3.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'aa5030cfa5405eccfdcb1083ce040c2cb8d253bf',
    ),
    'psr/cache-implementation' => 
    array (
      'provided' => 
      array (
        0 => '2.0|3.0',
      ),
    ),
    'psr/container' => 
    array (
      'pretty_version' => '1.1.2',
      'version' => '1.1.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '513e0666f7216c7459170d56df27dfcefe1689ea',
    ),
    'psr/container-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.1|2.0',
      ),
    ),
    'psr/event-dispatcher' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'dbefd12671e8a14ec7f180cab83036ed26714bb0',
    ),
    'psr/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/log' => 
    array (
      'pretty_version' => '3.0.2',
      'version' => '3.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f16e1d5863e37f8d8c2a01719f5b34baa2b714d3',
    ),
    'psr/log-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0|2.0|3.0',
      ),
    ),
    'psr/simple-cache-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0|2.0|3.0',
      ),
    ),
    'symfony/cache' => 
    array (
      'pretty_version' => 'v6.4.16',
      'version' => '6.4.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '70d60e9a3603108563010f8592dff15a6f15dfae',
    ),
    'symfony/cache-contracts' => 
    array (
      'pretty_version' => 'v3.5.1',
      'version' => '3.5.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '15a4f8e5cd3bce9aeafc882b1acab39ec8de2c1b',
    ),
    'symfony/cache-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.1|2.0|3.0',
      ),
    ),
    'symfony/config' => 
    array (
      'pretty_version' => 'v6.4.14',
      'version' => '6.4.14.0',
      'aliases' => 
      array (
      ),
      'reference' => '4e55e7e4ffddd343671ea972216d4509f46c22ef',
    ),
    'symfony/dependency-injection' => 
    array (
      'pretty_version' => 'v6.4.16',
      'version' => '6.4.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '7a379d8871f6a36f01559c14e11141cc02eb8dc8',
    ),
    'symfony/deprecation-contracts' => 
    array (
      'pretty_version' => 'v3.5.1',
      'version' => '3.5.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '74c71c939a79f7d5bf3c1ce9f5ea37ba0114c6f6',
    ),
    'symfony/error-handler' => 
    array (
      'pretty_version' => 'v6.4.14',
      'version' => '6.4.14.0',
      'aliases' => 
      array (
      ),
      'reference' => '9e024324511eeb00983ee76b9aedc3e6ecd993d9',
    ),
    'symfony/event-dispatcher' => 
    array (
      'pretty_version' => 'v6.4.13',
      'version' => '6.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => '0ffc48080ab3e9132ea74ef4e09d8dcf26bf897e',
    ),
    'symfony/event-dispatcher-contracts' => 
    array (
      'pretty_version' => 'v3.5.1',
      'version' => '3.5.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '7642f5e970b672283b7823222ae8ef8bbc160b9f',
    ),
    'symfony/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '2.0|3.0',
      ),
    ),
    'symfony/filesystem' => 
    array (
      'pretty_version' => 'v6.4.13',
      'version' => '6.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => '4856c9cf585d5a0313d8d35afd681a526f038dd3',
    ),
    'symfony/finder' => 
    array (
      'pretty_version' => 'v6.4.13',
      'version' => '6.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => 'daea9eca0b08d0ed1dc9ab702a46128fd1be4958',
    ),
    'symfony/framework-bundle' => 
    array (
      'pretty_version' => 'v5.4.45',
      'version' => '5.4.45.0',
      'aliases' => 
      array (
      ),
      'reference' => '3d70f14176422d4d8ee400b6acae4e21f7c25ca2',
    ),
    'symfony/http-foundation' => 
    array (
      'pretty_version' => 'v6.4.16',
      'version' => '6.4.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '431771b7a6f662f1575b3cfc8fd7617aa9864d57',
    ),
    'symfony/http-kernel' => 
    array (
      'pretty_version' => 'v6.4.16',
      'version' => '6.4.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '8838b5b21d807923b893ccbfc2cbeda0f1bc00f0',
    ),
    'symfony/polyfill-ctype' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a3cc8b044a6ea513310cbd48ef7333b384945638',
    ),
    'symfony/polyfill-intl-grapheme' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b9123926e3b7bc2f98c02ad54f6a4b02b91a8abe',
    ),
    'symfony/polyfill-intl-normalizer' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '3833d7255cc303546435cb650316bff708a1c75c',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '85181ba99b2345b0ef10ce42ecac37612d9fd341',
    ),
    'symfony/polyfill-php80' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '60328e362d4c2c802a54fcbf04f9d3fb892b4cf8',
    ),
    'symfony/polyfill-php81' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '4a4cfc2d253c21a5ad0e53071df248ed48c6ce5c',
    ),
    'symfony/polyfill-php83' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '2fb86d65e2d424369ad2905e83b236a8805ba491',
    ),
    'symfony/routing' => 
    array (
      'pretty_version' => 'v6.4.16',
      'version' => '6.4.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '91e02e606b4b705c2f4fb42f7e7708b7923a3220',
    ),
    'symfony/service-contracts' => 
    array (
      'pretty_version' => 'v2.5.4',
      'version' => '2.5.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f37b419f7aea2e9abf10abd261832cace12e3300',
    ),
    'symfony/service-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.1|2.0|3.0',
      ),
    ),
    'symfony/string' => 
    array (
      'pretty_version' => 'v7.2.0',
      'version' => '7.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '446e0d146f991dde3e73f45f2c97a9faad773c82',
    ),
    'symfony/translation-contracts' => 
    array (
      'pretty_version' => 'v3.5.1',
      'version' => '3.5.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '4667ff3bd513750603a09c8dedbea942487fb07c',
    ),
    'symfony/twig-bridge' => 
    array (
      'pretty_version' => 'v6.4.16',
      'version' => '6.4.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '32ec012ed4f6426441a66014471bdb26674744be',
    ),
    'symfony/twig-bundle' => 
    array (
      'pretty_version' => 'v5.4.45',
      'version' => '5.4.45.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e1ca56e1dc7791eb19f0aff71d3d94e6a91cc8f9',
    ),
    'symfony/var-dumper' => 
    array (
      'pretty_version' => 'v7.2.0',
      'version' => '7.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c6a22929407dec8765d6e2b6ff85b800b245879c',
    ),
    'symfony/var-exporter' => 
    array (
      'pretty_version' => 'v7.2.0',
      'version' => '7.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '1a6a89f95a46af0f142874c9d650a6358d13070d',
    ),
    'timber/timber' => 
    array (
      'pretty_version' => 'v2.3.0',
      'version' => '2.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '55acea4414eac6ea9d0a11a102af37cf13f219b2',
    ),
    'twig/extra-bundle' => 
    array (
      'pretty_version' => 'v3.17.0',
      'version' => '3.17.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '9746573ca4bc1cd03a767a183faadaf84e0c31fa',
    ),
    'twig/string-extra' => 
    array (
      'pretty_version' => 'v3.17.0',
      'version' => '3.17.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'cb4eec11de02f63ad8ea9d065a1f27752d0bf752',
    ),
    'twig/twig' => 
    array (
      'pretty_version' => 'v3.17.1',
      'version' => '3.17.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '677ef8da6497a03048192aeeb5aa3018e379ac71',
    ),
  ),
);
private static $canGetVendors;
private static $installedByVendor = array();







public static function getInstalledPackages()
{
$packages = array();
foreach (self::getInstalled() as $installed) {
$packages[] = array_keys($installed['versions']);
}


if (1 === \count($packages)) {
return $packages[0];
}

return array_keys(array_flip(\call_user_func_array('array_merge', $packages)));
}









public static function isInstalled($packageName)
{
foreach (self::getInstalled() as $installed) {
if (isset($installed['versions'][$packageName])) {
return true;
}
}

return false;
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

$ranges = array();
if (isset($installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = $installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['version'])) {
return null;
}

return $installed['versions'][$packageName]['version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getPrettyVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return $installed['versions'][$packageName]['pretty_version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getReference($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['reference'])) {
return null;
}

return $installed['versions'][$packageName]['reference'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getRootPackage()
{
$installed = self::getInstalled();

return $installed[0]['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
self::$installedByVendor = array();
}




private static function getInstalled()
{
if (null === self::$canGetVendors) {
self::$canGetVendors = method_exists('Composer\Autoload\ClassLoader', 'getRegisteredLoaders');
}

$installed = array();

if (self::$canGetVendors) {
foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
if (isset(self::$installedByVendor[$vendorDir])) {
$installed[] = self::$installedByVendor[$vendorDir];
} elseif (is_file($vendorDir.'/composer/installed.php')) {
$installed[] = self::$installedByVendor[$vendorDir] = require $vendorDir.'/composer/installed.php';
}
}
}

$installed[] = self::$installed;

return $installed;
}
}
