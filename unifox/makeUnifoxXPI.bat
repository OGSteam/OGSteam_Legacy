set x=UniFox
"%ProgramFiles%\7-Zip\7z.exe" a -tzip %x%.xpi * -r -mx=9 -xr!.svn -x!*.bat -x!*.xpi
