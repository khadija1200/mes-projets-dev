import React from "react";
import { Link } from "react-router-dom";
// reactstrap components
import {
  Collapse,
  DropdownToggle,
  DropdownMenu,
  DropdownItem,
  UncontrolledDropdown,
  NavbarBrand,
  Navbar,
  NavItem,
  NavLink,
  Nav,
  Container,
  UncontrolledTooltip,
} from "reactstrap";

function ExamplesNavbar({ userId, role, onLogout }) {
  const [navbarColor, setNavbarColor] = React.useState("navbar-transparent");
  const [collapseOpen, setCollapseOpen] = React.useState(false);
  React.useEffect(() => {
    const updateNavbarColor = () => {
      if (
        document.documentElement.scrollTop > 399 ||
        document.body.scrollTop > 399
      ) {
        setNavbarColor("");
      } else if (
        document.documentElement.scrollTop < 400 ||
        document.body.scrollTop < 400
      ) {
        setNavbarColor("navbar-transparent");
      }
    };
    window.addEventListener("scroll", updateNavbarColor);
    return function cleanup() {
      window.removeEventListener("scroll", updateNavbarColor);
    };
  });
  return (
    <>
      {collapseOpen ? (
        <div
          id="bodyClick"
          onClick={() => {
            document.documentElement.classList.toggle("nav-open");
            setCollapseOpen(false);
          }}
        />
      ) : null}
      <Navbar className={"fixed-top " + navbarColor} color="info" expand="lg">
        <Container>
          <UncontrolledDropdown className="button-dropdown">
            <DropdownToggle
              caret
              data-toggle="dropdown"
              href="#pablo"
              id="navbarDropdown"
              tag="a"
              onClick={(e) => e.preventDefault()}
            >
              <span className="button-bar"></span>
              <span className="button-bar"></span>
              <span className="button-bar"></span>
            </DropdownToggle>
            <DropdownMenu aria-labelledby="navbarDropdown">
              <DropdownItem header tag="a">
                Dropdown header
              </DropdownItem>
              <DropdownItem href="#pablo" onClick={(e) => e.preventDefault()}>
                Action
              </DropdownItem>
              <DropdownItem href="#pablo" onClick={(e) => e.preventDefault()}>
                Another action
              </DropdownItem>
              <DropdownItem href="#pablo" onClick={(e) => e.preventDefault()}>
                Something else here
              </DropdownItem>
              <DropdownItem divider></DropdownItem>
              <DropdownItem href="#pablo" onClick={(e) => e.preventDefault()}>
                Separated link
              </DropdownItem>
              <DropdownItem divider></DropdownItem>
              <DropdownItem href="#pablo" onClick={(e) => e.preventDefault()}>
                One more separated link
              </DropdownItem>
            </DropdownMenu>
          </UncontrolledDropdown>
          <div className="navbar-translate">
            <NavbarBrand
      
              target="_blank"
              id="navbar-brand"
            >
               <NavLink tag={Link} to="/index" style={{ fontSize: "0.8rem"}}> Acceuil</NavLink>
            
            </NavbarBrand>
            <UncontrolledTooltip target="#navbar-brand">
              Acceuil
            </UncontrolledTooltip>
            <button
              className="navbar-toggler navbar-toggler"
              onClick={() => {
                document.documentElement.classList.toggle("nav-open");
                setCollapseOpen(!collapseOpen);
              }}
              aria-expanded={collapseOpen}
              type="button"
            >
              <span className="navbar-toggler-bar top-bar"></span>
              <span className="navbar-toggler-bar middle-bar"></span>
              <span className="navbar-toggler-bar bottom-bar"></span>
            </button>
          </div>
          <Collapse
            className="justify-content-end"
            isOpen={collapseOpen}
            navbar
          >
            <Nav navbar>
              {userId ? (
                              <>
                               <NavItem>
                               <NavLink tag={Link} to="/profile-page" style={{ fontSize: "0.8rem"}}>
                                                               <i className="now-ui-icons users_circle-08" style={{ fontSize: "1rem", marginRight: "5px" }}></i>
                                                               <p>Mon compte</p>
                                                             </NavLink>
              
                              </NavItem>
              
                              <NavItem>
                                <NavLink style={{ fontSize: "0.8rem"}}
                                  href="#"
                                  onClick={(e) => {
                                    e.preventDefault();
                                    onLogout(); // Appelle la fonction de déconnexion
                                  }}
                                >
                                  <i style={{ fontSize: "1rem", marginRight: "5px"}} className="now-ui-icons ui-1_simple-remove"></i>
                                  <p>Se déconnecter</p>
                                </NavLink>
                                </NavItem>
                               
                              </>
              
                            ) : (
                               <>
              <NavItem>
                <NavLink tag={Link} to="/login" style={{ fontSize: "0.8rem"}}>
                                 <i className="now-ui-icons ui-1_lock-circle-open" style={{ fontSize: "1rem", marginRight: "5px" }}></i>
                                 <p>Se connecter</p>
                               </NavLink>
              </NavItem>
              <NavItem>
                 <NavLink tag={Link} to="/signup" style={{ fontSize: "0.8rem"}}  >
                                  <i className="now-ui-icons ui-1_simple-add" style={{ fontSize: "1rem", marginRight: "5px" }}></i>
                                  <p>S'inscrire</p>
                                </NavLink>
              </NavItem>
             
           </>
              )}   
            </Nav>
          </Collapse>
        </Container>
      </Navbar>
    </>
  );
}

export default ExamplesNavbar;
