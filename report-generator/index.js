const bodyParser = require("body-parser");
const docx = require("docx");
const cors = require("cors");
const express = require("express");
const app = express();
const fs = require("fs");
const { HeightRule } = require("docx");

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(cors());
app.use(express.static("public"));

const {
  Document,
  Paragraph,
  Table,
  TableCell,
  TableRow,
  PageOrientation,
  Packer,
} = docx;

const generateFirstTable = (data) => {
  return new Table({
    rows: [
      new TableRow({
        tableHeader: true,
        children: [
          new TableCell({
            children: [new Paragraph("Объект")],
          }),
          new TableCell({
            children: [new Paragraph("Уч")],
          }),
          new TableCell({
            children: [new Paragraph("№")],
          }),
          new TableCell({
            children: [new Paragraph("Жизненное состояние")],
          }),
          new TableCell({
            children: [new Paragraph("Порода")],
          }),
          new TableCell({
            children: [new Paragraph("Жизненная форма")],
          }),
          new TableCell({
            children: [new Paragraph("Тип насаждения")],
          }),
          new TableCell({
            children: [new Paragraph("Текущий возраст")],
          }),
          new TableCell({
            children: [new Paragraph("Высота")],
          }),
        ],
      }),
      ...data.map((object) => {
        return new TableRow({
          height: {
            rule: HeightRule.ATLEAST,
            value: 1,
          },
          children: [
            new TableCell({
              children: [new Paragraph(object.mainobject)],
            }),
            new TableCell({
              children: [new Paragraph(object.siteNumber.toString())],
            }),
            new TableCell({
              children: [new Paragraph(object.plantNumber.toString())],
            }),
            new TableCell({
              children: [new Paragraph(object.lifestatuscategory)],
            }),
            new TableCell({
              children: [new Paragraph(object.specie)],
            }),
            new TableCell({
              children: [new Paragraph(object.lifeform)],
            }),
            new TableCell({
              children: [new Paragraph(object.plantingtype)],
            }),
            new TableCell({
              children: [new Paragraph(object.currentAge.toString())],
            }),
            new TableCell({
              children: [new Paragraph(object.height)],
            }),
          ],
        });
      }),
    ],
  });
};

const generateSecondTable = (data) => {
  return new Table({
    rows: [
      new TableRow({
        children: [
          new TableCell({
            children: [new Paragraph("Широта")],
          }),
          new TableCell({
            children: [new Paragraph("Долгота")],
          }),
          new TableCell({
            children: [new Paragraph("Характеристика")],
          }),
          new TableCell({
            children: [new Paragraph("Рекомендации")],
          }),
          new TableCell({
            children: [new Paragraph("Дата Инвентаризации")],
          }),
          new TableCell({
            children: [new Paragraph("Диаметр на высоте 1.3м")],
          }),
        ],
      }),
      ...data.map((object) => {
        return new TableRow({
          children: [
            new TableCell({
              children: [new Paragraph(object.latitude)],
            }),
            new TableCell({
              children: [new Paragraph(object.longitude)],
            }),
            new TableCell({
              children: [new Paragraph(object.characteristic)],
            }),
            new TableCell({
              children: [
                new Paragraph(object.recommendation || "Нет рекомендаций"),
              ],
            }),
            new TableCell({
              children: [new Paragraph(object.inventDate)],
            }),
            new TableCell({
              children: [new Paragraph(object.diameterAtHeight13)],
            }),
          ],
        });
      }),
    ],
  });
};

const OBJECTS_ON_PAGE = 20;

app.post("/generate", async (req, res) => {
  const data = req.body;
  let sections = [];
  let startIdx = 0;
  do {
    let slicedData = data.slice(startIdx, startIdx + OBJECTS_ON_PAGE);
    startIdx += OBJECTS_ON_PAGE;
    sections = [
      ...sections,
      {
        size: {
          orientation: PageOrientation.LANDSCAPE,
        },
        children: [generateFirstTable(slicedData)],
      },
      {
        children: [generateSecondTable(slicedData)],
      },
    ];
  } while (startIdx < data.length);
  const doc = new Document({
    sections,
  });
  const buffer = await Packer.toBuffer(doc);
  const filename = new Date().getTime();
  fs.writeFileSync(`public/Report_${filename}.docx`, buffer);
  res.send({ success: true, filename });
});

const PORT = 3000;
app.listen(PORT, () => console.log(`App Started on port ${PORT}`));
