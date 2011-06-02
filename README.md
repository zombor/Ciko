Ciko is a lightweight continuous integration server written in Kohana.

It's best used with a single developer on your local machine while doing development. It's aim is to be an easy to use continuous integration server that a freelance developer can use independently.

## Install

Clone this repository (recommended location is a system-wide location like `/usr/local/ciko/`). If you want to look at project runs, you'll need to setup a webserver pointing at the `docroot/` folder.

Ciko is best used as a post-commit git hook on your local machine:

If you are using Ciko on your local machine for your local projects:

	/path/to/ciko/minion ciko:run --project=ciko

## Configuration

Configuration in Ciko is easy and pretty self-explanatory:

 - clone_path - The path on the filesystem where project clones will happen
 - projects - an array of `Model_Ciko_Project` objects. See the example config for details

## Reporters

You can specify reporters in the ciko config. Currently there is none written, but there is an easy interface for them and should be easy to make one for your specific need.

A reporter should take the output from a runner job, and turn it into a human readable format. An example is a Clover reporter that reads a clover.xml and gives you code coverage percentages.

## Notifiers

A notifier is similar to a reporter, except it can send an email out, or notify IRC.

### Currently implemented notifiers

#### Git

The git notifier tags the repository saying it ran a CI build on the repository. The tag name will be in the syntax of `ciko-#<build-number>`.

It will also push the tag to the cloned repository, so make sure the machine (and user) ciko is running under has permission to do that.

# Limitations

Ciko is designed to be fast, lightweight and easy to use. It doesn't:

 - have a queue
 - have user accounts
 - support anything other than git

And it never will.