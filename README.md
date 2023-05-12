<h1 dir="auto" tabindex="-1">Aspen Systems WordPress Skills Assessment</h1>
<h2 dir="auto" tabindex="-1">Custom Plugin Development Task</h2>
<p dir="auto">In this task you will ingest content from the New York Times' "Top Stories" API into WordPress. Below is a simple mockup of how this task would be detailed typical Phabricator request at Aspen Systems Inc. Before you dive into the story, here are a few development requirements.</p>

<h3 dir="auto" tabindex="-1">Instructions</h3>
<ul dir="auto">
 	<li>Fork/clone this repo locally.</li>
 	<li>Build/develop the plugin according to the requirements listed below.</li>
 	<li>Add the plugin to a vanilla install of running WordPress so you can demo your code during the interview process.</li>
 	<li>Be prepared to share a public link to your work during the interview process.</li>
</ul>
<h3 dir="auto" tabindex="-1">Restrictions</h3>
<ul dir="auto">
 	<li>
<p dir="auto">Do not create a plugin from scratch. Please use the plugin found in <code>wp-content/plugins/jh-nyt-top-stories</code>. This plugin uses the <a href="https://github.com/DevinVinson/WordPress-Plugin-Boilerplate">WordPress Plugin Boilerplate</a>, an Object-Oriented boilerplate used for plugin development at Janus Henderson.</p>
</li>
 	<li>
<p dir="auto">All development should be done in the <code>jh-nyt-top-stories</code> plugin. Do not create other plugins, files, or edit any theme files.</p>
</li>
</ul>

<hr />

<h3 dir="auto" tabindex="-1">Task Description</h3>
<p dir="auto">As a user, I want to have the New York Times "Top Stories" imported into WordPress on an hourly basis, so they can be used throughout the site.</p>

<h3 dir="auto" tabindex="-1"></a>Acceptance Criteria / Requirements</h3>
<ul dir="auto">
 	<li>
<p dir="auto">Create a new custom post type called "NYT Top Stories". This CPT should be public, and have both categories and tags, but not be searchable.</p>
</li>
 	<li>
<p dir="auto">Data should be sourced from <code>https://api.nytimes.com/svc/topstories/v2/home.json?api-key=[KEY_GOES_HERE]</code>. Each NYT story in the <code>results</code> section of the response should be imported into WP using the newly created CPT.</p>

<ul dir="auto">
 	<li><strong>NOTE: You can sign up for your own free key at <a href="https://developer.nytimes.com/" rel="nofollow">developer.nytimes.com</a></strong></li>
</ul>
</li>
 	<li>
<p dir="auto">The data from the API response should be mapped in WP as follows.</p>

<ul dir="auto">
 	<li>title --&gt; Post Title</li>
 	<li>abstract --&gt; Post Excerpt</li>
 	<li>published_date --&gt; Post Date</li>
 	<li>url --&gt; A post meta field called 'URL'</li>
 	<li>byline --&gt; A post meta field called 'byline'</li>
 	<li>section --&gt; Categories</li>
 	<li>des_facet --&gt; Tags</li>
</ul>
</li>
 	<li>
<p dir="auto">The import should run on an hourly basis using WP Cron</p>
</li>
 	<li>
<p dir="auto">NYT Stories should not be duplicated if they already exist WP. There is no need to update stories if they already exist in WP.</p>
</li>
 	<li>
<p dir="auto">Create a short code that lists the 5 newest stories</p>

<ul dir="auto">
 	<li>The stories should be displayed in an unordered list</li>
 	<li>The list should be ordered from newest to oldest</li>
 	<li>Each item in the list should include a title that links to the story with the byline underneath the title (the byline does not link to anything).</li>
</ul>
</li>
</ul>
<h3 dir="auto" tabindex="-1">Bonus Points</h3>
<p dir="auto">The below tasks are not required for this skill assessment, but they are worth a few bonus points :)</p>

<ul dir="auto">
 	<li>Create a WP CLI command that can be run to trigger the import at any time.</li>
 	<li>Create an admin page where a user can click a button to trigger an import.</li>
</ul>