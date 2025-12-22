import React from "react";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import Slider from "react-slick";
import { Container } from "reactstrap";

// Import du SearchBar
import SearchBar from "components/SearchBar"; // Assurez-vous que ce chemin est correct selon votre structure de projet.

function IndexHeader({ onSearch }) {
  let pageHeader = React.createRef();

  React.useEffect(() => {
    // Mettre à jour le scroll uniquement pour des largeurs d'écran spécifiques
    if (window.innerWidth > 991) {
      const updateScroll = () => {
        if (pageHeader.current) {  // Vérification que la référence existe avant d'utiliser
          let windowScrollTop = window.pageYOffset / 3;
          pageHeader.current.style.transform =
            "translate3d(0," + windowScrollTop + "px,0)";
        }
      };

      window.addEventListener("scroll", updateScroll);
      return () => {
        window.removeEventListener("scroll", updateScroll);
      };
    }
  }, []);  // Ajouter un tableau de dépendances vide pour ne l'exécuter qu'une fois

  const images = [
    require("assets/img/architecte.jpg"),
    require("assets/img/nutritionniste.jpg"),
    require("assets/img/patissier.jpg"),
    require("assets/img/menuisier.jpg")
  ];

  const settings = {
    autoplay: true,
    infinite: true,
    speed: 2000,
    autoplaySpeed: 5000,
    fade: true,
    arrows: false,
    dots: false,
    pauseOnHover: false
  };

  return (
    <>
      <div className="page-header clear-filter" filter-color="blue">
        <div className="page-header-image" ref={pageHeader}>
          <Slider {...settings}>
            {images.map((img, index) => (
              <div key={index}>
                <div
                  style={{
                    height: "100vh",
                    backgroundImage: `url(${img})`,
                    backgroundSize: "cover",
                    backgroundPosition: "center"
                  }}
                />
              </div>
            ))}
          </Slider>
        </div>

        <Container>
          <div className="content-center brand">
            <img
              alt="..."
              className="n-logo"
              src={require("assets/img/now-logo.png")}
            />
            <h3 style={{ fontSize: "2.3em" }}>Prenez RDV avec un artisan ou professionnel pour vos projets!</h3>
          </div>

          {/* Intégration du SearchBar juste après le logo et le slogan */}
          <div className="search-bar-container">
          <SearchBar onSearch={onSearch} />
          </div>
        </Container>
      </div>
    </>
  );
}

export default IndexHeader;
