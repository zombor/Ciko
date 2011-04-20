Ciko is a lightweight continuous integration server written in Kohana.

It's best used with a single developer on your local machine while doing development. It's aim is to be an easy to use continuous integration server that a freelance developer can use independently.

## Install

Clone this repository. If you want to look at project runs, you'll need to setup a webserver pointing at the `docroot/` folder.

Ciko is best used as a pre-commit (local hosted, recommended) or post-commit (remote-hosted, not recommended) git hook:

.git/hooks/pre-commit

	./minion ciko:run --project=ciko

If you are using a post-commit hook and want to have a remote server build, you'll need to do a POST request to `/ciko/run/<project-slug>`:

	curl -d "" http://example.com/ciko/run/<project-slug>

## Configuration

Configuration in Ciko is easy and pretty self-explanatory:

 - clone_path - The path on the filesystem where project clones will happen
 - projects - an array of `Model_Ciko_Project` objects. See the example config for details

## Reporters

You can specify reporters in the ciko config. Currently there is none written, but there is an easy interface for them and should be easy to make one for your specific need.

A reporter should take the output from a runner job, and turn it into a human readable format. An example is a Clover reporter that reads a clover.xml and gives you code coverage percentages.

## Notifiers

A notifier is similar to a reporter, except it can send an email out, or notify IRC.

# Limitations

Ciko is designed to be fast, lightweight and easy to use. It doesn't:

 - have a queue
 - have user accounts
 - support anything other than git

And it never will.