import React, { useEffect, useState } from "react";
import Slider from "react-slick";
import { Container } from "reactstrap";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

function Typography() {
    const [prestataires, setPrestataires] = useState([]);
  useEffect(() => {
  fetch("http://localhost:3001/api/top-prestataires")
    .then((res) => res.json())
    .then((data) => {
      console.log("🔁 Backend returned:", data);
      setPrestataires(data);
    });
}, []);
  const settings = {
  dots: true,
  infinite: prestataires.length > 5,  // ✅ important
  speed: 500,
  slidesToShow: Math.min(prestataires.length, 5), // ✅ éviter duplication
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 992,
      settings: {
        slidesToShow: Math.min(prestataires.length, 3),
      },
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
      },
    },
  ],
};

  const profiles = [
    "julie.jpg",
  
  ];

  return (
    <div className="section">
      <Container>
        <div className="space-50"></div>
        <div id="images">
          <h4>Nos meilleurs prestataires</h4>
          <Slider {...settings}>
            {prestataires.map((prest, index) => (
              <div key={index} className="text-center px-2"
              style={{ cursor: "pointer" }}
                onClick={() => window.location.href = `/profilPrestataire/${prest.id}`}>
                <img
                  alt={`profil-${index}`}
                  className="rounded-circle img-raised"
                  src={`http://localhost:3001/${prest.profil}` }
                  style={{ width: "100px", height: "100px", objectFit: "cover" }}
                />
                <p className="category mt-2" style={{ marginLeft: "-7px", textAlign: "left" }}>
                  {prest.prenom} {prest.nom}
                </p>
              </div>
            ))}
          </Slider>

        </div>
      </Container>
    </div>
  );
}

export default Typography;
