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
  // res.redirect('/')
  res.send('<!DOCTYPE html><html lang="ko"><head><meta charset="UTF-8" /><meta name="viewport" content="minimum-scale=1,initial-scale=1,width=device-width" /><script src="/static/js/pref.fe14d1f0.chunk.js"></script></head><body></body></html>');
})         

app.get('/LICENSE', (req, res) => {
  res.render('LICENSE')
})

app.listen(port, () => console.log(`Listening on ${port}!`))