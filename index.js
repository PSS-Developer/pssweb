const express = require('express')

const app = express()
const bodyParser = require('body-parser');
const port = process.env.PORT || 3000

app.use(express.json())
app.use(express.static('public'))
app.use(bodyParser.urlencoded({extended: false}));
app.use(bodyParser.json());


app.set('views', './views')
app.set('view engine', 'ejs')

app.get('/', (req, res) => {
  res.render('index')
})

app.get('/index', (req, res) => {
  res.redirect('/')
})

app.get('/about', (req, res) => {
  res.render('about')
})            

app.get('/join', (req, res) => {
  res.redirect('https://discord.gg/qBbvk2vzPM')
  // res.render('prepsk')
})         

app.get('/LICENSE', (req, res) => {
  res.render('LICENSE')
})

app.listen(port, () => console.log(`Listening on ${port}!`))