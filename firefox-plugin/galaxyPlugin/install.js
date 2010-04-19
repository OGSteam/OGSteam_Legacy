// constants
const APP_DISPLAY_NAME = "Galaxytoolbar";
const APP_NAME = "galaxyplugin";
const APP_PACKAGE = "/galaxyplugin";
const APP_VERSION = "1.4.2";
const WARNING = "WARNING: You need administrator priviledges to install Galaxytoolbar. It will be installed in the application directory for all users. Installing Galaxy Toolbar in your profile is only supported for Firefox 0.9+. Proceed with the installation?";
const locales = ["pl-PL", "en-US", "de-DE", "fr-FR", "es-ES"];

if (confirm(WARNING)) {
  /* Pre-Install Cleanup (for prior versions) */
  
  // file-check array
  var dirArray = [
    [getFolder("Profile", "chrome"), "galaxyplugin.jar"],      // Profile jar
    [getFolder("Chrome"), "galaxyplugin.jar"],                 // Root jar
    [getFolder("Profile"), "XUL FastLoad File"],              // XUL cache Mac Classic
    [getFolder("Profile"), "XUL.mfast"],                      // XUL cache MacOS X
    [getFolder("Profile"), "XUL.mfasl"],                      // XUL cache Linux
    [getFolder("Profile"), "XUL.mfl"]                         // XUL cache Windows
  ];
  
  // Remove any existing files
  initInstall("pre-install", "/rename", "0.0");  // open dummy-install
  for (var i = 0 ; i < dirArray.length ; i++) {
    var currentDir = dirArray[i][0];
    var name = dirArray[i][1];
    var oldFile = getFolder(currentDir, name);

    // Find a name to rename the file into
    var newName = name + "-uninstalled";
    for (var n = 1; File.exists(oldFile) && File.exists(getFolder(currentDir, newName)); n++)
      newName = name + n + "-uninstalled";
  
    if (File.exists(oldFile))
      File.rename(oldFile, newName);
  }
  performInstall(); // commit renamed files

  /* Main part of the installation */

  var files = [
    ["chrome/galaxyplugin.jar", getFolder("Chrome")],
   // ["defaults/preferences/adblockplus.js", getFolder(getFolder("Program", "defaults"), "pref")],
	null
  ];
  
  // initialize our install
  initInstall(APP_NAME, APP_PACKAGE, APP_VERSION);
  
  // Add files
  for (var i = 0; i < files.length; i++)
    addFile(APP_NAME, APP_VERSION, files[i][0], files[i][1], null);

  var jar = getFolder(getFolder("Chrome"), "galaxyplugin.jar");
  try {
    var err = registerChrome(CONTENT | DELAYED_CHROME, jar, "content/");
    if (err != SUCCESS)
      throw "Chrome registration for content failed (error code " + err + ").";

    err = registerChrome(SKIN | DELAYED_CHROME, jar, "skin/classic/");
    if (err != SUCCESS)
      throw "Chrome registration for skin failed (error code " + err + ").";

    for (i = 0; i < locales.length; i++) {
      if (!locales[i])
        continue;

      err = registerChrome(LOCALE | DELAYED_CHROME, jar, "locale/" + locales[i] + "/");
      if (err != SUCCESS)
        throw "Chrome registration for " + locales[i] + " locale failed (error code " + err + ").";
    }

    var err = performInstall();
    if (err != SUCCESS && err != 999)
      throw "Committing installation failed (error code " + err + ").";

    alert("Galaxy Toolbar " + APP_VERSION + " is now installed.\n" +
          "It will become active after you restart your browser.");
  }
  catch (ex) {
    alert("Installation failed: " + ex + "\n" +
          "You probably don't have the necessary permissions (log in as system administrator).");
    cancelInstall(err);
  } 
}
