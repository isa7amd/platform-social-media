<?php
// cookies are already available automatically
?>

<nav style="margin-bottom:15px; padding:10px; border-bottom:2px solid #333;">

    <a href="projecthome333.php">
        HOME
    </a>

    |

    <a href="projectsearch333.php">
        SEARCH
    </a>

    |

    <a href="projectcreate333.php">
        ADD NEW POST
    </a>

    |

    <a href="editprofile.php">
        EDIT PROFILE
    </a>


    <?php if(isset($_COOKIE['full_name'])): ?>

        |

        <span>
            Hi,
            <?= htmlspecialchars($_COOKIE['full_name']); ?>
        </span>

    <?php endif; ?>


    |

    <form 
    action="logout333.php" 
    method="post" 
    style="display:inline;"
    >

        <button
        type="submit"
        name="logout"
        style="
        border:none;
        background:none;
        color:blue;
        text-decoration:underline;
        cursor:pointer;
        padding:0;
        font:inherit;
        "
        >

        LOG OUT

        </button>


    </form>


</nav>