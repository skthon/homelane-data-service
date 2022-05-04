<h1 id="homelane-price-prediction-bot">Homelane Price Prediction Bot</h1>
<hr>
<h1 id="table-of-contents">Table of Contents</h1>
<ul>
<li><a href="#requirements-installation">Requirements &amp; Installation</a></li>
<li><a href="#available-apis">Available APIs</a></li>
<li><a href="#micro-services">Microservices</a><ul>
<li><a href="#data-service">Data Service</a><ul>
<li><a href="#data-api">Data API</a></li>
</ul>
</li>
<li><a href="#query-service">Query service</a><ul>
<li><a href="#budget-homes-api">Budget Homes API</a></li>
<li><a href="#sqft-homes-api">SQFT Homes API</a></li>
<li><a href="#age-homes-api">Age Homes API</a></li>
<li><a href="#standard-price-api">Standard Price API</a></li>
</ul>
</li>
</ul>
</li>
</ul>
<hr>
<h1 id="requirements-installation">Requirements &amp; Installation</h1>
<ul>
<li>PHP 7.4</li>
<li>Composer 2.0+</li>
<li>Data service <ul>
<li><a href="https://github.com/skthon/homelane-data-service">https://github.com/skthon/homelane-data-service</a></li>
<li><a href="https://homelane-laravel-data.herokuapp.com/">https://homelane-laravel-data.herokuapp.com/</a></li>
</ul>
</li>
<li>Query service<ul>
<li><a href="https://github.com/skthon/homelane-query-service">https://github.com/skthon/homelane-query-service</a></li>
<li><a href="https://homelane-laravel-query.herokuapp.com/">https://homelane-laravel-query.herokuapp.com/</a></li>
</ul>
</li>
<li><p>Installation and commands</p>
<ul>
<li>Create a folder and Clone the repos from above<pre><code>gh repo <span class="hljs-keyword">clone</span> <span class="hljs-title">skthon</span>/homelane-query-service
gh repo <span class="hljs-keyword">clone</span> <span class="hljs-title">skthon</span>/homelane-data-service
</code></pre></li>
<li><p>Run the below commands in both the services</p>
<pre><code>    <span class="hljs-comment"># Data service</span>
    composer <span class="hljs-keyword">install</span>
    php artisan migrate
    php artisan db:seed
    php artisan serve --port=<span class="hljs-number">8081</span>

    <span class="hljs-comment"># Query service</span>
    composer <span class="hljs-keyword">install</span>
    php artisan migrate
    php artisan db:seed
    php artisan serve
</code></pre></li>
</ul>
</li>
</ul>
<hr>
<h1 id="notes-on-know-issues">Notes on know issues</h1>
<ul>
<li>Currently facing issues with the heroku mysql/sqlite/pgsql. Tried all of them, there are multiple issues popped up with each of them. The price column doesn&#39;t contain the accurate value as it is trimmed to three digit number in mysql db. This needs to be fixed.</li>
<li>Although there are multiple issues on heroku, but the local installation will work fine with sqlite database.</li>
<li>In online application, the API response could be considerably slow since the heroku tries to go to sleep when its idle for 30 minutes.</li>
</ul>
<hr>
<h1 id="available-apis">Available APIs</h1>
<ul>
<li>Demo account<ul>
<li>email: demo@homelane.com</li>
<li>password: <code>demopassword</code></li>
<li>access_token: <code>4|apfnqS5VhIRdOilrLKbrwc3WorajoghNIYVXaBxH</code></li>
</ul>
</li>
</ul>
<ul>
<li><p>Register account using api. This will return the access token/bearer token for accessing APIs. </p>
<pre><code>  curl -X POST <span class="hljs-string">"https://homelane-laravel-query.herokuapp.com/api/account/register"</span> \
      -H <span class="hljs-string">"Accept: application/json"</span> \
      -H <span class="hljs-string">"Content-Type: application/json"</span> \
      -d <span class="hljs-string">'{"</span>name<span class="hljs-string">": "</span>&lt;&gt;<span class="hljs-string">", "</span>email<span class="hljs-string">":"</span>&lt;&gt;<span class="hljs-string">", "</span>password<span class="hljs-string">":"</span>&lt;&gt;<span class="hljs-string">"}'</span>
</code></pre></li>
<li><p>Login to account using api. This will return the access token/bearer token for accessing APIs. </p>
<pre><code>  curl -X POST "https://homelane-laravel-query.herokuapp.com/api/account/login" \
      -<span class="ruby">H <span class="hljs-string">"Accept: application/json"</span> \
</span>      -<span class="ruby">H <span class="hljs-string">"Content-Type: application/json"</span> \
</span>      -<span class="ruby">d <span class="hljs-string">'{"email":"&lt;&gt;", "password":"&lt;&gt;"}'</span></span>
</code></pre></li>
<li><p>Budget Homes API</p>
<pre><code>  curl -X POST "https://homelane-laravel-query.herokuapp.com/api/homes/budget" \
      -<span class="ruby">H <span class="hljs-string">"Accept: application/json"</span> \
</span>      -<span class="ruby">H <span class="hljs-string">"Content-Type: application/json"</span> \
</span>      -<span class="ruby">H <span class="hljs-string">"Authorization: Bearer 4|apfnqS5VhIRdOilrLKbrwc3WorajoghNIYVXaBxH"</span> \
</span>      -<span class="ruby">d <span class="hljs-string">'{"minPrice":10, "maxPrice":1000000000}'</span></span>
</code></pre></li>
<li><p>Sqft Homes API</p>
<pre><code>  curl -X POST "https://homelane-laravel-query.herokuapp.com/api/homes/sqft" \
      -<span class="ruby">H <span class="hljs-string">"Accept: application/json"</span> \
</span>      -<span class="ruby">H <span class="hljs-string">"Content-Type: application/json"</span> \
</span>      -<span class="ruby">H <span class="hljs-string">"Authorization: Bearer 4|apfnqS5VhIRdOilrLKbrwc3WorajoghNIYVXaBxH"</span> \
</span>      -<span class="ruby">d <span class="hljs-string">'{"minSqft":5000}'</span></span>
</code></pre></li>
<li><p>Age Homes API</p>
<pre><code>  curl -X POST "https://homelane-laravel-query.herokuapp.com/api/homes/age" \
      -<span class="ruby">H <span class="hljs-string">"Accept: application/json"</span> \
</span>      -<span class="ruby">H <span class="hljs-string">"Content-Type: application/json"</span> \
</span>      -<span class="ruby">H <span class="hljs-string">"Authorization: Bearer 4|apfnqS5VhIRdOilrLKbrwc3WorajoghNIYVXaBxH"</span> \
</span>      -<span class="ruby">d <span class="hljs-string">'{"year":2010}'</span></span>
</code></pre></li>
<li><p>Standard Price API (response contains <code>standardized_price</code> field)</p>
<pre><code>  curl -X POST "https://homelane-laravel-query.herokuapp.com/api/homes/standard_price" \
      -<span class="ruby">H <span class="hljs-string">"Accept: application/json"</span> \
</span>      -<span class="ruby">H <span class="hljs-string">"Content-Type: application/json"</span> \
</span>      -<span class="ruby">H <span class="hljs-string">"Authorization: Bearer 4|apfnqS5VhIRdOilrLKbrwc3WorajoghNIYVXaBxH"</span> \
</span>      -<span class="ruby">d <span class="hljs-string">"{}"</span></span>
</code></pre></li>
<li><p>Accessing data service directly. </p>
<pre><code>  curl -X POST <span class="hljs-string">"https://homelane-laravel-data.herokuapp.com/api/data"</span> \
      -H <span class="hljs-string">"Accept: application/json"</span> \
      -H <span class="hljs-string">"Content-Type: application/json"</span> \
      -d '{<span class="hljs-string">"min_price"</span>: <span class="hljs-number">0</span>,<span class="hljs-string">"max_price"</span>: <span class="hljs-number">100000000000000</span>,<span class="hljs-string">"min_sqft_living"</span>: <span class="hljs-number">10</span>,<span class="hljs-string">"min_year"</span>: <span class="hljs-number">1800</span>,<span class="hljs-string">"bypass_ip"</span>: <span class="hljs-literal">true</span>}'
</code></pre></li>
</ul>
<hr>
<h1 id="microservices">Microservices</h1>
<h2 id="data-service">Data Service</h2>
<h3 id="data-api">Data API</h3>
<ul>
<li>POST request</li>
<li>URLS<ul>
<li><a href="http://localhost:8081/api/data">http://localhost:8081/api/data</a></li>
<li><a href="https://homelane-laravel-data.herokuapp.com/api/data">https://homelane-laravel-data.herokuapp.com/api/data</a></li>
</ul>
</li>
<li>Accepted parameters<ul>
<li><code>min_year</code><ul>
<li>Accepts integer.</li>
<li>Used by Age Homes API </li>
</ul>
</li>
<li><code>max_price</code> <ul>
<li>Accepts integer.</li>
<li>Used by Budget Homes API</li>
</ul>
</li>
<li><code>min_price</code> <ul>
<li>Accepts integer.</li>
<li>Used by Budget Homes API</li>
</ul>
</li>
<li><code>min_sqft_living</code> <ul>
<li>Accepts integer.</li>
<li>Used by Sqft Homes API</li>
</ul>
</li>
<li><code>bypass_ip</code> <ul>
<li>Accepts boolean.</li>
<li>This needs to be specified in the api to bypass ip address restrictions. This is a serious security issue and need to be avoided, but since heroku platform doesn&#39;t support static ip address, i have implemented this for temporary purpose.</li>
</ul>
</li>
</ul>
</li>
<li>POST Request body<pre><code>  {
      <span class="hljs-attr">"min_price"</span>: <span class="hljs-number">0</span>,
      <span class="hljs-attr">"max_price"</span>: <span class="hljs-number">10000000000000</span>,
      <span class="hljs-attr">"min_sqft_living"</span>: <span class="hljs-number">10</span>,
      <span class="hljs-attr">"min_year"</span>: <span class="hljs-number">1800</span>,
      <span class="hljs-attr">"bypass_ip"</span>:<span class="hljs-literal">true</span>
  }
</code></pre></li>
<li>Response Body<pre><code>  {
      <span class="hljs-attr">"data"</span>: [
          {
              <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
              <span class="hljs-attr">"uuid"</span>: <span class="hljs-string">"9635a34f-83ff-4285-873e-1248825a96fd"</span>,
              <span class="hljs-attr">"date"</span>: <span class="hljs-string">"2014-05-02T00:00:00.000000Z"</span>,
              <span class="hljs-attr">"price"</span>: <span class="hljs-string">"313000.0"</span>,
              <span class="hljs-attr">"bedrooms"</span>: <span class="hljs-string">"3"</span>,
              <span class="hljs-attr">"bathrooms"</span>: <span class="hljs-string">"1.5"</span>,
              <span class="hljs-attr">"sqft_living"</span>: <span class="hljs-string">"1340"</span>,
              <span class="hljs-attr">"sqft_lot"</span>: <span class="hljs-string">"7912"</span>,
              <span class="hljs-attr">"floors"</span>: <span class="hljs-string">"1.5"</span>,
              <span class="hljs-attr">"waterfront"</span>: <span class="hljs-string">"0"</span>,
              <span class="hljs-attr">"view"</span>: <span class="hljs-string">"0"</span>,
              <span class="hljs-attr">"condition"</span>: <span class="hljs-string">"3"</span>,
              <span class="hljs-attr">"sqft_above"</span>: <span class="hljs-string">"1340"</span>,
              <span class="hljs-attr">"sqft_basement"</span>: <span class="hljs-string">"0"</span>,
              <span class="hljs-attr">"year_built"</span>: <span class="hljs-string">"1955"</span>,
              <span class="hljs-attr">"year_renovated"</span>: <span class="hljs-string">"2005"</span>,
              <span class="hljs-attr">"street"</span>: <span class="hljs-string">"18810 Densmore Ave N"</span>,
              <span class="hljs-attr">"city"</span>: <span class="hljs-string">"Shoreline"</span>,
              <span class="hljs-attr">"state_zip"</span>: <span class="hljs-string">"WA 98133"</span>,
              <span class="hljs-attr">"country"</span>: <span class="hljs-string">"USA"</span>,
              <span class="hljs-attr">"created_at"</span>: <span class="hljs-string">"2022-05-03T09:46:13.000000Z"</span>,
              <span class="hljs-attr">"updated_at"</span>: <span class="hljs-string">"2022-05-03T09:46:13.000000Z"</span>,
              <span class="hljs-attr">"standardized_price"</span>: <span class="hljs-number">442566.48</span>
          },
          .....
      ]
  }
</code></pre></li>
<li>Errors<ul>
<li>Internal error with 500 response</li>
<li>Invalid input with 400 response</li>
</ul>
</li>
</ul>
<hr>
<h2 id="query-service">Query service</h2>
<h3 id="budget-homes-api">Budget Homes API</h3>
<ul>
<li>POST request</li>
<li>URLS<ul>
<li><a href="http://127.0.0.1:8000/api/homes/budget">http://127.0.0.1:8000/api/homes/budget</a></li>
<li><a href="https://homelane-laravel-query.herokuapp.com/api/homes/budget">https://homelane-laravel-query.herokuapp.com/api/homes/budget</a></li>
</ul>
</li>
<li>POST Request body<pre><code>{
  <span class="hljs-attr">"minPrice"</span>: <span class="hljs-number">100</span>,
  <span class="hljs-attr">"maxPrice"</span>: <span class="hljs-number">1000000000</span>
}
</code></pre></li>
<li>Response Body<pre><code>  {
      <span class="hljs-attr">"data"</span>: [
          {
              <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
              <span class="hljs-attr">"uuid"</span>: <span class="hljs-string">"9635a34f-83ff-4285-873e-1248825a96fd"</span>,
              <span class="hljs-attr">"date"</span>: <span class="hljs-string">"2014-05-02T00:00:00.000000Z"</span>,
              <span class="hljs-attr">"price"</span>: <span class="hljs-string">"313000.0"</span>,
              <span class="hljs-attr">"bedrooms"</span>: <span class="hljs-string">"3"</span>,
              <span class="hljs-attr">"bathrooms"</span>: <span class="hljs-string">"1.5"</span>,
              <span class="hljs-attr">"sqft_living"</span>: <span class="hljs-string">"1340"</span>,
              <span class="hljs-attr">"sqft_lot"</span>: <span class="hljs-string">"7912"</span>,
              <span class="hljs-attr">"floors"</span>: <span class="hljs-string">"1.5"</span>,
              <span class="hljs-attr">"waterfront"</span>: <span class="hljs-string">"0"</span>,
              <span class="hljs-attr">"view"</span>: <span class="hljs-string">"0"</span>,
              <span class="hljs-attr">"condition"</span>: <span class="hljs-string">"3"</span>,
              <span class="hljs-attr">"sqft_above"</span>: <span class="hljs-string">"1340"</span>,
              <span class="hljs-attr">"sqft_basement"</span>: <span class="hljs-string">"0"</span>,
              <span class="hljs-attr">"year_built"</span>: <span class="hljs-string">"1955"</span>,
              <span class="hljs-attr">"year_renovated"</span>: <span class="hljs-string">"2005"</span>,
              <span class="hljs-attr">"street"</span>: <span class="hljs-string">"18810 Densmore Ave N"</span>,
              <span class="hljs-attr">"city"</span>: <span class="hljs-string">"Shoreline"</span>,
              <span class="hljs-attr">"state_zip"</span>: <span class="hljs-string">"WA 98133"</span>,
              <span class="hljs-attr">"country"</span>: <span class="hljs-string">"USA"</span>,
              <span class="hljs-attr">"created_at"</span>: <span class="hljs-string">"2022-05-03T09:46:13.000000Z"</span>,
              <span class="hljs-attr">"updated_at"</span>: <span class="hljs-string">"2022-05-03T09:46:13.000000Z"</span>,
              <span class="hljs-attr">"standardized_price"</span>: <span class="hljs-number">442566.48</span>
          },
          .....
      ]
  }
</code></pre></li>
<li>Errors<ul>
<li>Internal error with 500 response</li>
<li>Invalid input with 400 response</li>
</ul>
</li>
</ul>
<h3 id="sqft-homes-api">SQFT Homes API</h3>
<ul>
<li>POST request</li>
<li>URLS<ul>
<li><a href="http://127.0.0.1:8000/api/homes/sqft">http://127.0.0.1:8000/api/homes/sqft</a></li>
<li><a href="https://homelane-laravel-query.herokuapp.com/api/homes/sqft">https://homelane-laravel-query.herokuapp.com/api/homes/sqft</a></li>
</ul>
</li>
<li><p>POST Request body</p>
<pre><code>  {
      <span class="hljs-attr">"minSqft"</span>: <span class="hljs-number">10</span>,
  }
</code></pre></li>
<li><p>Response Body</p>
<pre><code>  {
      <span class="hljs-attr">"data"</span>: [
          {
              <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
              <span class="hljs-attr">"uuid"</span>: <span class="hljs-string">"9635a34f-83ff-4285-873e-1248825a96fd"</span>,
              <span class="hljs-attr">"date"</span>: <span class="hljs-string">"2014-05-02T00:00:00.000000Z"</span>,
              <span class="hljs-attr">"price"</span>: <span class="hljs-string">"313000.0"</span>,
              <span class="hljs-attr">"bedrooms"</span>: <span class="hljs-string">"3"</span>,
              <span class="hljs-attr">"bathrooms"</span>: <span class="hljs-string">"1.5"</span>,
              <span class="hljs-attr">"sqft_living"</span>: <span class="hljs-string">"1340"</span>,
              <span class="hljs-attr">"sqft_lot"</span>: <span class="hljs-string">"7912"</span>,
              <span class="hljs-attr">"floors"</span>: <span class="hljs-string">"1.5"</span>,
              <span class="hljs-attr">"waterfront"</span>: <span class="hljs-string">"0"</span>,
              <span class="hljs-attr">"view"</span>: <span class="hljs-string">"0"</span>,
              <span class="hljs-attr">"condition"</span>: <span class="hljs-string">"3"</span>,
              <span class="hljs-attr">"sqft_above"</span>: <span class="hljs-string">"1340"</span>,
              <span class="hljs-attr">"sqft_basement"</span>: <span class="hljs-string">"0"</span>,
              <span class="hljs-attr">"year_built"</span>: <span class="hljs-string">"1955"</span>,
              <span class="hljs-attr">"year_renovated"</span>: <span class="hljs-string">"2005"</span>,
              <span class="hljs-attr">"street"</span>: <span class="hljs-string">"18810 Densmore Ave N"</span>,
              <span class="hljs-attr">"city"</span>: <span class="hljs-string">"Shoreline"</span>,
              <span class="hljs-attr">"state_zip"</span>: <span class="hljs-string">"WA 98133"</span>,
              <span class="hljs-attr">"country"</span>: <span class="hljs-string">"USA"</span>,
              <span class="hljs-attr">"created_at"</span>: <span class="hljs-string">"2022-05-03T09:46:13.000000Z"</span>,
              <span class="hljs-attr">"updated_at"</span>: <span class="hljs-string">"2022-05-03T09:46:13.000000Z"</span>,
              <span class="hljs-attr">"standardized_price"</span>: <span class="hljs-number">442566.48</span>
          },
          .....
      ]
  }
</code></pre></li>
<li><p>Errors</p>
<ul>
<li>Internal error with 500 response</li>
<li>Invalid input with 400 response</li>
</ul>
</li>
</ul>
<h3 id="age-homes-api">Age Homes API</h3>
<ul>
<li>POST request</li>
<li>URLS<ul>
<li><a href="http://127.0.0.1:8000/api/homes/age">http://127.0.0.1:8000/api/homes/age</a></li>
<li><a href="https://homelane-laravel-query.herokuapp.com/api/homes/age">https://homelane-laravel-query.herokuapp.com/api/homes/age</a></li>
</ul>
</li>
<li>POST Request body<pre><code>  {
      <span class="hljs-attr">"year"</span>: <span class="hljs-number">1900</span>
  }
</code></pre></li>
<li>Response Body<pre><code>  {
      <span class="hljs-attr">"data"</span>: [
          {
              <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
              <span class="hljs-attr">"uuid"</span>: <span class="hljs-string">"9635a34f-83ff-4285-873e-1248825a96fd"</span>,
              <span class="hljs-attr">"date"</span>: <span class="hljs-string">"2014-05-02T00:00:00.000000Z"</span>,
              <span class="hljs-attr">"price"</span>: <span class="hljs-string">"313000.0"</span>,
              <span class="hljs-attr">"bedrooms"</span>: <span class="hljs-string">"3"</span>,
              <span class="hljs-attr">"bathrooms"</span>: <span class="hljs-string">"1.5"</span>,
              <span class="hljs-attr">"sqft_living"</span>: <span class="hljs-string">"1340"</span>,
              <span class="hljs-attr">"sqft_lot"</span>: <span class="hljs-string">"7912"</span>,
              <span class="hljs-attr">"floors"</span>: <span class="hljs-string">"1.5"</span>,
              <span class="hljs-attr">"waterfront"</span>: <span class="hljs-string">"0"</span>,
              <span class="hljs-attr">"view"</span>: <span class="hljs-string">"0"</span>,
              <span class="hljs-attr">"condition"</span>: <span class="hljs-string">"3"</span>,
              <span class="hljs-attr">"sqft_above"</span>: <span class="hljs-string">"1340"</span>,
              <span class="hljs-attr">"sqft_basement"</span>: <span class="hljs-string">"0"</span>,
              <span class="hljs-attr">"year_built"</span>: <span class="hljs-string">"1955"</span>,
              <span class="hljs-attr">"year_renovated"</span>: <span class="hljs-string">"2005"</span>,
              <span class="hljs-attr">"street"</span>: <span class="hljs-string">"18810 Densmore Ave N"</span>,
              <span class="hljs-attr">"city"</span>: <span class="hljs-string">"Shoreline"</span>,
              <span class="hljs-attr">"state_zip"</span>: <span class="hljs-string">"WA 98133"</span>,
              <span class="hljs-attr">"country"</span>: <span class="hljs-string">"USA"</span>,
              <span class="hljs-attr">"created_at"</span>: <span class="hljs-string">"2022-05-03T09:46:13.000000Z"</span>,
              <span class="hljs-attr">"updated_at"</span>: <span class="hljs-string">"2022-05-03T09:46:13.000000Z"</span>,
              <span class="hljs-attr">"standardized_price"</span>: <span class="hljs-number">442566.48</span>
          },
          .....
      ]
  }
</code></pre></li>
<li>Errors<ul>
<li>Internal error with 500 response</li>
<li>Invalid input with 400 response</li>
</ul>
</li>
</ul>
<h3 id="standard-price-api">Standard Price API</h3>
<ul>
<li>POST request</li>
<li>URLS<ul>
<li><a href="http://127.0.0.1:8000/api/homes/standard_price">http://127.0.0.1:8000/api/homes/standard_price</a></li>
<li><a href="https://homelane-laravel-query.herokuapp.com/api/homes/standard_price">https://homelane-laravel-query.herokuapp.com/api/homes/standard_price</a></li>
</ul>
</li>
<li>POST Request body<pre><code>  {}
</code></pre></li>
<li><p>Response Body</p>
<pre><code>  {
      <span class="hljs-string">"data"</span>: [
          {
              ....
              <span class="hljs-string">"standardized_price"</span>: <span class="hljs-number">442566.48</span>
          },
          .....
      ]
  }
</code></pre></li>
<li>Errors<ul>
<li>Internal error with 500 response</li>
<li>Invalid input with 400 response</li>
</ul>
</li>
</ul>
