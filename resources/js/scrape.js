const puppeteer = require('puppeteer');

(async () => {
  const cmpNumber = process.argv[2];
  const browser = await puppeteer.launch({ headless: "new" });
  const page = await browser.newPage();
console.log('dasdas');
  await page.goto('https://www.cmp.org.pe/conoce-a-tu-medico/');
  await page.waitForSelector('input[name="cmp"]');
  await page.type('input[name="cmp"]', cmpNumber);
  await page.click('input[type="submit"]');
  await page.waitForSelector('table');

  const data = await page.evaluate(() => {
    const rows = Array.from(document.querySelectorAll('table tr'));
    return rows.map(row => {
      const cols = Array.from(row.querySelectorAll('td'));
      return cols.map(col => col.innerText.trim());
    });
  });

  console.log(JSON.stringify(data));
  await browser.close();
})();
