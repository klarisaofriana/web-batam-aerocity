// server.js
import express from "express";
import cors from "cors";
import path from "path";
import { fileURLToPath } from "url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
const PORT = 3000;

app.use(cors());
app.use(express.static(path.join(__dirname, "/")));

// Dummy data berita
const berita = Array.from({ length: 30 }, (_, i) => ({
  id: i + 1,
  title: `Judul Berita ${i + 1}`,
  date: `2024-11-${(i + 10).toString().padStart(2, "0")}`,
  image: `https://via.placeholder.com/400x200?text=Berita+${i + 1}`,
  excerpt: `Deskripsi singkat berita ke-${i + 1} mengenai Batam AeroCity.`,
  url: "#",
}));

// API berita dengan pagination + search
app.get("/api/berita", (req, res) => {
  const page = parseInt(req.query.page) || 1;
  const limit = parseInt(req.query.limit) || 8;
  const query = (req.query.q || "").toLowerCase();

  let filtered = berita;
  if (query) {
    filtered = berita.filter((b) => b.title.toLowerCase().includes(query));
  }

  const startIndex = (page - 1) * limit;
  const endIndex = startIndex + limit;
  const items = filtered.slice(startIndex, endIndex);

  res.json({
    items,
    meta: {
      totalData: filtered.length,
      totalPages: Math.ceil(filtered.length / limit),
      currentPage: page,
    },
  });
});

// =====================
// Tambahan API CUACA
// =====================
app.get("/api/cuaca/:id", async (req, res) => {
  try {
    const id = req.params.id; // contoh: 501195 untuk Batam
    const response = await fetch(
      `https://ibnux.github.io/BMKG-importer/cuaca/${id}.json`
    );
    const data = await response.json();
    res.json(data);
  } catch (err) {
    res.status(500).json({ error: "Gagal ambil data cuaca" });
  }
});

// Daftar kota
app.get("/api/wilayah", async (req, res) => {
  try {
    const response = await fetch(
      "https://ibnux.github.io/BMKG-importer/cuaca/wilayah.json"
    );
    const data = await response.json();
    res.json(data);
  } catch (err) {
    res.status(500).json({ error: "Gagal ambil data wilayah" });
  }
});

app.listen(PORT, () => {
  console.log(`✅ Server berjalan di http://localhost:${PORT}`);
  console.log(`✅ Buka: http://localhost:${PORT}/berita.html`);
  console.log(
    `✅ API Cuaca: http://localhost:${PORT}/api/cuaca/501195 (Batam)`
  );
  console.log(`✅ API Wilayah: http://localhost:${PORT}/api/wilayah`);
});
